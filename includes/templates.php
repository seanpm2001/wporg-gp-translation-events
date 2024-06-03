<?php

namespace Wporg\TranslationEvents;

class Templates {
	private static bool $use_new_design = false;

	public static function use_new_design( bool $also_in_production = false ): void {
		if ( $also_in_production ) {
			// If it's enabled for production, it's also enabled for development, so it's always enabled.
			self::$use_new_design = true;
		} else {
			// Only enable if new design has been explicitly enabled.
			self::$use_new_design = defined( 'TRANSLATION_EVENTS_NEW_DESIGN' ) && TRANSLATION_EVENTS_NEW_DESIGN;
		}

		if ( self::$use_new_design ) {
			// TODO.
		}
	}

	public static function render( string $template, array $data = array() ) {
		gp_tmpl_load( $template, $data, __DIR__ . '/../templates/' );
	}

	public static function header( array $data ) {
		self::part( 'header', $data );
	}

	public static function footer( array $data = array() ) {
		self::part( 'footer', $data );
	}

	public static function part( string $template, array $data ) {
		self::render( "parts/$template", $data );
	}
}
