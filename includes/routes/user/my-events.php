<?php

namespace Wporg\TranslationEvents\Routes\User;

use DateTime;
use DateTimeZone;
use WP_Query;
use Wporg\TranslationEvents\Attendee_Repository;
use Wporg\TranslationEvents\Event\Event_Repository_Interface;
use Wporg\TranslationEvents\Routes\Route;
use Wporg\TranslationEvents\Translation_Events;

/**
 * Displays the My Events page for a user.
 */
class My_Events_Route extends Route {
	private Event_Repository_Interface $event_repository;
	private Attendee_Repository $attendee_repository;

	public function __construct() {
		parent::__construct();
		$this->event_repository    = Translation_Events::get_event_repository();
		$this->attendee_repository = Translation_Events::get_attendee_repository();
	}

	public function handle(): void {
		global $wp;
		if ( ! is_user_logged_in() ) {
			wp_safe_redirect( wp_login_url( home_url( $wp->request ) ) );
			exit;
		}
		include ABSPATH . 'wp-admin/includes/post.php';

		$_events_i_created_paged  = 1;
		$_events_i_attended_paged = 1;

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['events_i_created_paged'] ) ) {
			$value = sanitize_text_field( wp_unslash( $_GET['events_i_created_paged'] ) );
			if ( is_numeric( $value ) ) {
				$_events_i_created_paged = (int) $value;
			}
		}
		if ( isset( $_GET['events_i_attended_paged'] ) ) {
			$value = sanitize_text_field( wp_unslash( $_GET['events_i_attended_paged'] ) );
			if ( is_numeric( $value ) ) {
				$_events_i_attended_paged = (int) $value;
			}
		}
		// phpcs:enable

		$events_i_created_query = $this->event_repository->get_events_created_by_user( get_current_user_id(), $_events_i_created_paged, 10 );

		$current_datetime_utc = ( new DateTime( 'now', new DateTimeZone( 'UTC' ) ) )->format( 'Y-m-d H:i:s' );

		$args = array(
			'post_type'               => Translation_Events::CPT,
			'posts_per_page'          => 10,
			'events_i_attended_paged' => $_events_i_attended_paged,
			'paged'                   => $_events_i_attended_paged,
			'post_status'             => 'publish',
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'meta_query'              => array(
				array(
					'key'     => '_event_end',
					'value'   => $current_datetime_utc,
					'compare' => '<',
					'type'    => 'DATETIME',
				),
			),
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_key'                => '_event_end',
			'orderby'                 => 'meta_value',
			'order'                   => 'DESC',
		);

		$user_id                  = get_current_user_id();
		$user_attending_event_ids = $this->attendee_repository->get_events_for_user( $user_id );
		if ( empty( $user_attending_event_ids ) ) {
			// Setting it to an array with a single 0 element will result in the query returning zero results,
			// which is what we want, as the user is not attending any events.
			$user_attending_event_ids = array( 0 );
		}
		$args['post__in'] = $user_attending_event_ids;

		$events_i_attended_query = new WP_Query( $args );
		$this->tmpl( 'events-my-events', get_defined_vars() );
	}
}
