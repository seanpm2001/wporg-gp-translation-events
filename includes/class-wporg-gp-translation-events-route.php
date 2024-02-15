<?php

/**
 * Routes: WPORG_GP_Translation_Events_Route class
 *
 * @package wporg-gp-translation-events
 */
class WPORG_GP_Translation_Events_Route extends GP_Route {
	public const USER_META_KEY_ATTENDING = 'translation-events-attending';

	/**
	 * WPORG_GP_Translation_Events_Route constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$this->template_path = dirname( __FILE__ ) . '/../templates/';
	}

	/**
	 * Loads the 'events_list' template.
	 *
	 * @return void
	 */
	public function events_list() {
		$current_datetime_utc   = ( new DateTime( 'now', new DateTimeZone( 'UTC' ) ) )->format( 'Y-m-d H:i:s' );
		$_current_events_paged  = isset( $_GET['current_events_paged'] ) && is_numeric( $_GET['current_events_paged'] ) ? $_GET['current_events_paged'] : 1;
		$_upcoming_events_paged = isset( $_GET['upcoming_events_paged'] ) && is_numeric( $_GET['upcoming_events_paged'] ) ? $_GET['upcoming_events_paged'] : 1;

		$current_events_args  = array(
			'post_type'            => 'event',
			'posts_per_page'       => 10,
			'current_events_paged' => $_current_events_paged,
			'paged'                => $_current_events_paged,
			'post_status'          => 'publish',
			'meta_query'           => array(
				array(
					'key'     => '_event_start',
					'value'   => $current_datetime_utc,
					'compare' => '<=',
					'type'    => 'DATETIME',
				),
				array(
					'key'     => '_event_end',
					'value'   => $current_datetime_utc,
					'compare' => '>=',
					'type'    => 'DATETIME',
				),
			),
			'orderby'              => 'meta_value',
			'order'                => 'ASC',
		);
		$current_events_query = new WP_Query( $current_events_args );

		$upcoming_events_args  = array(
			'post_type'             => 'event',
			'posts_per_page'        => 10,
			'upcoming_events_paged' => $_upcoming_events_paged,
			'paged'                 => $_upcoming_events_paged,
			'post_status'           => 'publish',
			'meta_query'            => array(
				array(
					'key'     => '_event_start',
					'value'   => $current_datetime_utc,
					'compare' => '>=',
					'type'    => 'DATETIME',
				),
			),
			'orderby'               => 'meta_value',
			'order'                 => 'ASC',
		);
		$upcoming_events_query = new WP_Query( $upcoming_events_args );
		$this->tmpl( 'events-list', get_defined_vars() );
	}

	/**
	 * Loads the 'events_create' template.
	 *
	 * @return void
	 */
	public function events_create() {
		if ( ! is_user_logged_in() ) {
			$this->die_with_error( 'You must be logged in to create an event', 403 );
		}
		$event_form_title  = 'Create Event';
		$event_form_name   = 'create_event';
		$css_show_url      = 'hide-event-url';
		$event_id          = null;
		$event_title       = '';
		$event_description = '';
		$event_timezone    = '';
		$event_start       = '';
		$event_end         = '';

		$this->tmpl( 'events-form', get_defined_vars() );
	}

	/**
	 * Loads the 'events_edit' template.
	 *
	 * @param int $event_id The event ID.
	 *
	 * @return void
	 */
	public function events_edit( $event_id ) {
		if ( ! is_user_logged_in() ) {
			$this->die_with_error( 'You must be logged in to edit an event', 403 );
		}
		$event = get_post( $event_id );
		if ( ! $event || 'event' !== $event->post_type || ! ( current_user_can( 'edit_post', $event->ID ) || intval( $event->post_author ) === get_current_user_id() ) ) {
			$this->die_with_error( 'Event does not exist, or you do not have permission to edit it.', 403 );
		}

		include ABSPATH . 'wp-admin/includes/post.php';
		$event_form_title              = 'Edit Event';
		$event_form_name               = 'edit_event';
		$css_show_url                  = '';
		$event_title                   = $event->post_title;
		$event_description             = $event->post_content;
		$event_timezone                = get_post_meta( $event_id, '_event_timezone', true ) ?: '';
		$event_start                   = self::convertToTimezone( get_post_meta( $event_id, '_event_start', true ), $event_timezone ) ?? '';
		$event_end                     = self::convertToTimezone( get_post_meta( $event_id, '_event_end', true ), $event_timezone ) ?? '';
		$event_status                  = $event->post_status;
		list( $permalink, $post_name ) = get_sample_permalink( $event_id );
		$permalink                     = str_replace( '%pagename%', $post_name, $permalink );
		$this->tmpl( 'events-form', get_defined_vars() );
	}

	/**
	 * Loads the 'event' template.
	 *
	 * @param string $event_slug The event slug.
	 *
	 * @return void
	 */
	public function events_details( $event_slug ) {
		$user  = wp_get_current_user();
		$event = get_page_by_path( $event_slug, OBJECT, 'event' );
		if ( ! $event ) {
			$this->die_with_404();
		}

		$event_id            = $event->ID;
		$event_title         = $event->post_title;
		$event_description   = $event->post_content;
		$event_start         = get_post_meta( $event->ID, '_event_start', true ) ?: '';
		$event_end           = get_post_meta( $event->ID, '_event_end', true ) ?: '';
		$attending_event_ids = get_user_meta( $user->ID, self::USER_META_KEY_ATTENDING, true ) ?: array();
		$user_is_attending   = isset( $attending_event_ids[ $event_id ] );

		$stats_calculator = new WPORG_GP_Translation_Events_Stats_Calculator();
		try {
			$event_stats = $stats_calculator->for_event( $event );
		} catch ( Exception $e ) {
			error_log( $e );
			$this->die_with_error( 'Failed to calculate event stats' );
		}

		$this->tmpl( 'event', get_defined_vars() );
	}

	/**
	 * Toggle whether the current user is attending an event.
	 * If the user is not currently marked as attending, they will be marked as attending.
	 * If the user is currently marked as attending, they will be marked as not attending.
	 *
	 * @param int $event_id
	 */
	public function events_attend( int $event_id ) {
		$user = wp_get_current_user();
		if ( ! $user ) {
			$this->die_with_error( 'Only logged-in users can attend events', 403 );
		}

		$event = get_post( $event_id );
		if ( ! $event ) {
			$this->die_with_404();
		}

		$event_ids = get_user_meta( $user->ID, self::USER_META_KEY_ATTENDING, true ) ?? array();
		if ( ! $event_ids ) {
			$event_ids = array();
		}

		if ( ! isset( $event_ids[ $event_id ] ) ) {
			// Not yet attending, mark as attending.
			$event_ids[ $event_id ] = true;
		} else {
			// Currently attending, mark as not attending.
			unset( $event_ids[ $event_id ] );
		}

		update_user_meta( $user->ID, self::USER_META_KEY_ATTENDING, $event_ids );

		wp_safe_redirect( gp_url( "/events/$event->post_name" ) );
		exit;
	}

	/**
	 * Loads the 'events_user_created' template.
	 *
	 * @return void
	 */
	public function events_user_created() {
		if ( ! is_user_logged_in() ) {
			$this->die_with_error( 'You must be logged in to your events', 403 );
		}
		include ABSPATH . 'wp-admin/includes/post.php';

		$user_id = get_current_user_id();
		$_paged  = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
		$args    = array(
			'post_type'      => 'event',
			'posts_per_page' => 10,
			'post_status'    => array( 'publish', 'draft' ),
			'paged'          => $_paged,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'author'         => $user_id,

		);
		$query = new WP_Query( $args );
		$this->tmpl( 'events-user-created', get_defined_vars() );
	}

	/**
	 * Convert date time stored in UTC to a date time in a time zone.
	 *
	 * @param string $date_time The date time in UTC.
	 * @param string $time_zone The time zone.
	 *
	 * @return string The date time in the time zone.
	 */
	public static function convertToTimezone( $date_time, $time_zone ) {
		return ( new DateTime( $date_time, new DateTimeZone( 'UTC' ) ) )->setTimezone( new DateTimeZone( $time_zone ) )->format( 'Y-m-d H:i:s' );
	}
}
