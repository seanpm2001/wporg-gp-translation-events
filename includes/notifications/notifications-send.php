<?php

namespace Wporg\TranslationEvents\Notifications;

use DateTime;
use DateTimeZone;
use Wporg\TranslationEvents\Attendee\Attendee;
use Wporg\TranslationEvents\Attendee\Attendee_Repository;
use Wporg\TranslationEvents\Event\Event;
use Wporg\TranslationEvents\Event\Event_Repository_Interface;
use WP_User;
use Wporg\TranslationEvents\Event\Event_Start_Date;

class Notifications_Send {

	private Attendee_Repository $attendee_repository;
	private Event_Repository_Interface $event_repository;

	/**
	 * Notifications_Cron constructor.
	 *
	 * @param Event_Repository_Interface $event_repository    Event repository.
	 * @param Attendee_Repository        $attendee_repository Attendee repository.
	 */
	public function __construct(
		Event_Repository_Interface $event_repository,
		Attendee_Repository $attendee_repository
	) {
		$this->event_repository    = $event_repository;
		$this->attendee_repository = $attendee_repository;
		add_action( 'wporg_gp_translation_events_email_notifications_1h', array( $this, 'send_notification' ), 10, 1 );
		add_action( 'wporg_gp_translation_events_email_notifications_24h', array( $this, 'send_notification' ), 10, 1 );
	}

	/**
	 * Send notifications to the attendees of the event.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public function send_notification( int $post_id ) {
		$event     = $this->event_repository->get_event( $post_id );
		$attendees = $this->attendee_repository->get_attendees( $event->id() );
		foreach ( $attendees as $attendee ) {
			$this->send_email_notification( $event, $attendee );
		}
	}

	/**
	 * Send an email notification to the attendee of the event.
	 *
	 * @param Event    $event        The event.
	 * @param Attendee $attendee     The attendee.
	 *
	 * @return void
	 */
	public function send_email_notification( Event $event, Attendee $attendee ): void {
		$user    = get_user_by( 'ID', $attendee->user_id() );
		$subject = $this->get_email_subject( $event );
		$message = $this->get_email_message( $user, $event );
		wp_mail(
			$user->user_email,
			$subject,
			$message,
			'Content-Type: text/html'
		);
	}

	/**
	 * Get the email subject.
	 *
	 * @param Event $event The event.
	 *
	 * @return string
	 */
	private function get_email_subject( Event $event ): string {
		$subject = esc_html__( 'Event Reminder. ', 'gp-translation-events' );
		// translators: %s: Event title.
		$subject .= sprintf( esc_html__( 'You have the %s event in', 'gp-translation-events' ), esc_html( $event->title() ) );
		$subject .= ' ';
		$subject .= $this->calculate_time_until_event( $event->start() );

		return $subject;
	}

	/**
	 * Get the email message.
	 *
	 * @param WP_User $user         The user.
	 * @param Event   $event        The event.
	 *
	 * @return string
	 */
	private function get_email_message( WP_User $user, Event $event ): string {
		$start_date = $event->start();
		// translators: %s: User display name.
		$message  = sprintf( esc_html__( 'Hi %s', 'gp-translation-events' ), $user->display_name );
		$message .= '<br><br>';
		// translators: %s: Event title.
		$message         .= sprintf( esc_html__( 'You have the %s event in', 'gp-translation-events' ), esc_html( $event->title() ) );
		$message         .= ' ';
		$message         .= $this->calculate_time_until_event( $event->start() ) . '.';
		$message         .= '<br>';
		$local_start_date = $event->start()->setTimezone( new DateTimeZone( $event->timezone()->getName() ) );
		// translators: %s: Event start date in 'Y-m-d H:i' format.
		$message .= sprintf( esc_html__( 'The event will start at %s', 'gp-translation-events' ), $local_start_date->format( 'Y-m-d H:i' ) );
		$message .= ' ';
		// translators: %s: Event timezone name.
		$message .= sprintf( esc_html__( '(local %s time).', 'gp-translation-events' ), $local_start_date->getTimezone()->getName() );
		$message .= '<br><br>';
		$message .= sprintf(
			wp_kses(
			// translators: %s: Event permalink.
				__( 'You can get more info about the event or stop attending the event <a href="%s">at this link</a>.', 'gp-translation-events' ),
				array( 'a' => array( 'href' => array() ) )
			),
			esc_url( home_url( gp_url( wp_make_link_relative( get_the_permalink( $event->id() ) ) ) ) )
		);
		$message .= '<br><br>';
		$message .= esc_html__( 'Have a nice day', 'gp-translation-events' );
		$message .= '<br><br>';
		$message .= esc_html__( 'The Global Polyglots Team', 'gp-translation-events' );
		$message .= '<br>';

		return $message;
	}

	/**
	 * Calculate the time until the event starts.
	 *
	 * @param Event_Start_Date $start_date The start date of the event.
	 *
	 * @return string
	 */
	private function calculate_time_until_event( Event_Start_Date $start_date ): string {
		$now              = new DateTime( 'now', new DateTimeZone( 'UTC' ) );
		$diff             = $start_date->diff( $now );
		$days_to_start    = $diff->days;
		$hours_to_start   = $diff->h;
		$minutes_to_start = $diff->i;
		$message          = '';
		if ( $days_to_start >= 1 ) {
			// translators: %d: Number of days.
			$message .= sprintf( _n( '%d day', '%d days', $days_to_start, 'gp-translation-events' ), $days_to_start );
		} elseif ( $hours_to_start > 1 ) {
			// translators: %d: Number of hours.
			$message .= sprintf( esc_html__( '%d hours', 'gp-translation-events' ), $hours_to_start );
		} elseif ( 1 === $hours_to_start ) {
			// translators: %d: Number of minutes.
			$message .= sprintf( _n( '1 hour and %d minute', '1 hour and %d minutes', $minutes_to_start, 'gp-translation-events' ), $minutes_to_start );
		} else {
			// translators: %d: Number of minutes.
			$message .= sprintf( _n( '%d minute', '%d minutes', $minutes_to_start, 'gp-translation-events' ), $minutes_to_start );
		}
		return $message;
	}
}
