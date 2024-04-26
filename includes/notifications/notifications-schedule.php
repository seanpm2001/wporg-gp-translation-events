<?php

namespace Wporg\TranslationEvents\Notifications;

use Wporg\TranslationEvents\Attendee\Attendee_Repository;
use Wporg\TranslationEvents\Event\Event_Repository_Interface;

class Notifications_Schedule {
	private Event_Repository_Interface $event_repository;

	/**
	 * Notifications_Cron constructor.
	 *
	 * @param Event_Repository_Interface $event_repository    Event repository.
	 */
	public function __construct( Event_Repository_Interface $event_repository ) {
		$this->event_repository = $event_repository;
	}

	/**
	 * Schedule emails for events.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public function schedule_emails( int $post_id ) {
		$event = $this->event_repository->get_event( $post_id );
		if ( ! $event ) {
			return;
		}
		$args = array(
			'post_id' => $post_id,
		);
		$this->delete_scheduled_emails( $post_id );
		if ( 'publish' === get_post_status( $post_id ) ) {
			$new_next_1h_schedule  = $event->start()->getTimestamp() - HOUR_IN_SECONDS;
			$new_next_24h_schedule = $event->start()->getTimestamp() - 24 * HOUR_IN_SECONDS;
			wp_schedule_single_event( $new_next_1h_schedule, 'wporg_gp_translation_events_email_notifications_1h', $args );
			wp_schedule_single_event( $new_next_24h_schedule, 'wporg_gp_translation_events_email_notifications_24h', $args );
		}
	}

	/**
	 * Delete scheduled emails for events.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public function delete_scheduled_emails( int $post_id ) {
		$args = array(
			'post_id' => $post_id,
		);

		$next_1h_schedule  = wp_next_scheduled( 'wporg_gp_translation_events_email_notifications_1h', $args );
		$next_24h_schedule = wp_next_scheduled( 'wporg_gp_translation_events_email_notifications_24h', $args );
		if ( $next_1h_schedule ) {
			wp_unschedule_event( $next_1h_schedule, 'wporg_gp_translation_events_email_notifications_1h', $args );
		}
		if ( $next_24h_schedule ) {
			wp_unschedule_event( $next_24h_schedule, 'wporg_gp_translation_events_email_notifications_24h', $args );
		}
	}
}
