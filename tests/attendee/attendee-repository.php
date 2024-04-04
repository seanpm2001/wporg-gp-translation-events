<?php

namespace Wporg\Tests\Attendee;

use WP_UnitTestCase;
use Wporg\TranslationEvents\Attendee\Attendee;
use Wporg\TranslationEvents\Attendee\Attendee_Repository;

class Attendee_Repository_Test extends WP_UnitTestCase {
	private Attendee_Repository $repository;

	protected function setUp(): void {
		parent::setUp();
		$this->repository = new Attendee_Repository();
	}

	public function test_add_attendee_invalid_event_id() {
		$this->expectExceptionMessage( 'invalid event id' );
		$this->repository->add_attendee( new Attendee( 0, 1 ) );
	}

	public function test_add_attendee_invalid_user_id() {
		$this->expectExceptionMessage( 'invalid user id' );
		$this->repository->add_attendee( new Attendee( 1, 0 ) );
	}

	public function test_add_attendee() {
		$event1_id = 1;
		$event2_id = 2;
		$user_id   = 42;

		$this->repository->add_attendee( new Attendee( $event1_id, $user_id ) );
		$this->repository->add_attendee( new Attendee( $event2_id, $user_id ) );

		$rows = $this->all_table_rows();
		$this->assertCount( 2, $rows );
		$this->assertEquals( $event1_id, $rows[0]->event_id );
		$this->assertEquals( $event2_id, $rows[1]->event_id );
	}

	public function test_remove_attendee() {
		$event1_id = 1;
		$event2_id = 2;
		$user_id   = 42;

		$this->repository->add_attendee( new Attendee( $event1_id, $user_id ) );
		$this->repository->add_attendee( new Attendee( $event2_id, $user_id ) );

		$this->repository->remove_attendee( new Attendee( $event1_id, $user_id ) );

		$rows = $this->all_table_rows();
		$this->assertCount( 1, $rows );
		$this->assertEquals( $event2_id, $rows[0]->event_id );
	}

	public function test_is_attending() {
		$event1_id = 1;
		$event2_id = 2;
		$user_id   = 42;

		$this->repository->add_attendee( new Attendee( $event1_id, $user_id ) );

		$this->assertTrue( $this->repository->is_attending( new Attendee( $event1_id, $user_id ) ) );
		$this->assertFalse( $this->repository->is_attending( new Attendee( $event2_id, $user_id ) ) );
	}

	public function test_get_events_for_user() {
		$event1_id    = 1;
		$event2_id    = 2;
		$event3_id    = 3;
		$user_id      = 42;
		$another_user = $user_id + 1;

		$this->repository->add_attendee( new Attendee( $event1_id, $user_id ) );
		$this->repository->add_attendee( new Attendee( $event2_id, $user_id ) );
		$this->repository->add_attendee( new Attendee( $event3_id, $another_user ) );

		$this->assertEquals( array( $event1_id, $event2_id ), $this->repository->get_events_for_user( $user_id ) );
		$this->assertEquals( array( $event3_id ), $this->repository->get_events_for_user( $another_user ) );
		$this->assertEmpty( $this->repository->get_events_for_user( $another_user + 1 ) );
	}

	private function all_table_rows(): array {
		global $wpdb, $gp_table_prefix;
		// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery
		// phpcs:disable WordPress.DB.DirectDatabaseQuery.NoCaching
		return $wpdb->get_results( "select * from {$gp_table_prefix}event_attendees order by event_id, user_id" );
		// phpcs:enable
	}
}
