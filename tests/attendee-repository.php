<?php

namespace Wporg\Tests;

use WP_UnitTestCase;
use Wporg\TranslationEvents\Attendee_Repository;

class Attendee_Repository_Test extends WP_UnitTestCase {
	private Attendee_Repository $repository;

	protected function setUp(): void {
		parent::setUp();
		$this->repository = new Attendee_Repository();
	}

	public function test_add_attendee_invalid_event_id() {
		$this->expectExceptionMessage( 'invalid event id' );
		$this->repository->add_attendee( 0, 1 );
	}

	public function test_add_attendee_invalid_user_id() {
		$this->expectExceptionMessage( 'invalid user id' );
		$this->repository->add_attendee( 1, 0 );
	}

	public function test_add_attendee() {
		$event1_id = 1;
		$event2_id = 2;
		$user_id   = 42;

		$this->repository->add_attendee( $event1_id, $user_id );
		$this->repository->add_attendee( $event2_id, $user_id );

		$event_ids = get_user_meta( $user_id, Attendee_Repository::USER_META_KEY, true );
		$this->assertCount( 2, $event_ids );
		$this->assertTrue( $event_ids[ $event1_id ] );
		$this->assertTrue( $event_ids[ $event2_id ] );

		$event_ids_another_user = get_user_meta( $user_id + 1, Attendee_Repository::USER_META_KEY, true );
		$this->assertEmpty( $event_ids_another_user );
	}
}
