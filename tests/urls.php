<?php

namespace Wporg\Tests;

use GP_UnitTestCase;
use Wporg\TranslationEvents\Attendee\Attendee_Repository;
use Wporg\TranslationEvents\Event\Event_Repository;
use Wporg\TranslationEvents\Tests\Event_Factory;
use Wporg\TranslationEvents\Urls;

class Urls_Test extends GP_UnitTestCase {
	private Event_Factory $event_factory;
	private Event_Repository $event_repository;

	public function setUp(): void {
		parent::setUp();
		$this->event_factory    = new Event_Factory();
		$this->event_repository = new Event_Repository( new Attendee_Repository() );
		$this->set_normal_user_as_current();
	}

	public function test_event_details() {
		$event_id = $this->event_factory->create_active();
		$event    = $this->event_repository->get_event( $event_id );

		$expected = "/glotpress/events/{$event->slug()}";
		$this->assertEquals( $expected, Urls::event_details( $event_id ) );
	}

	public function test_event_details_absolute() {
		$event_id = $this->event_factory->create_active();
		$event    = $this->event_repository->get_event( $event_id );

		$expected = site_url() . "/glotpress/events/{$event->slug()}";
		$this->assertEquals( $expected, Urls::event_details_absolute( $event_id ) );
	}

	public function test_event_edit() {
		$event_id = $this->event_factory->create_active();

		$expected = "/glotpress/events/edit/$event_id";
		$this->assertEquals( $expected, Urls::event_edit( $event_id ) );
	}

	public function test_event_create() {
		$expected = '/glotpress/events/new';
		$this->assertEquals( $expected, Urls::event_create() );
	}

	public function test_my_events() {
		$expected = '/glotpress/events/my-events';
		$this->assertEquals( $expected, Urls::my_events() );
	}
}
