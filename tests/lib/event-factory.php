<?php

namespace Wporg\TranslationEvents\Tests;

use DateTimeImmutable;
use DateTimeZone;
use WP_UnitTest_Factory_For_Post;
use WP_UnitTest_Generator_Sequence;

class Event_Factory extends WP_UnitTest_Factory_For_Post {
	public function __construct( $factory = null ) {
		parent::__construct( $factory );
		$this->default_generation_definitions = array(
			'post_status'  => 'publish',
			'post_title'   => new WP_UnitTest_Generator_Sequence( 'Event title %s' ),
			'post_content' => new WP_UnitTest_Generator_Sequence( 'Event content %s' ),
			'post_excerpt' => new WP_UnitTest_Generator_Sequence( 'Event excerpt %s' ),
			'post_type'    => 'event',
		);
	}

	public function create_active(): int {
		$event_id = $this->create();
		$now      = new DateTimeImmutable( 'now', new DateTimeZone( 'UTC' ) );

		update_post_meta( $event_id, '_event_start', $now->modify( '-1 hours' ) );
		update_post_meta( $event_id, '_event_end', $now->modify( '+1 hours' ) );

		return $event_id;
	}
}
