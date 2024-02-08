<?php

class WPORG_GP_Translation_Events_Active_Events_Cache_Entry {
	public int $event_id;
	public DateTimeImmutable $start;
	public DateTimeImmutable $end;

	public function __construct( int $event_id, DateTimeImmutable $start, DateTimeImmutable $end ) {
		$this->event_id = $event_id;
		$this->start    = $start;
		$this->end      = $end;
	}
}

class WPORG_GP_Translation_Events_Active_Events_Cache {
	public const CACHE_DURATION = 60 * 60 * 24; // 24 hours.
	private const KEY = 'translation-events-active-events';

	/**
	 * @param WPORG_GP_Translation_Events_Active_Events_Cache_Entry[] $cache_entries
	 *
	 * @throws Exception
	 */
	public function cache( array $cache_entries ): void {
		if ( ! wp_cache_set( self::KEY, $cache_entries, '', self::CACHE_DURATION ) ) {
			throw new Exception( 'Failed to cache active events' );
		}
	}

	/**
	 * Returns the cached entries, or null if nothing is cached.
	 *
	 * @return WPORG_GP_Translation_Events_Active_Events_Cache_Entry[]|null
	 * @throws Exception
	 */
	public function get(): ?array {
		$result = wp_cache_get( self::KEY, '', false, $found );
		if ( ! $found ) {
			return null;
		}

		if ( ! is_array( $result ) ) {
			throw new Exception( 'Cached event ids is not an array, something is wrong' );
		}

		return $result;
	}

	/**
	 * @throws Exception
	 */
	public function invalidate(): void {
		if ( ! wp_cache_delete( self::KEY ) ) {
			throw new Exception( 'Failed to invalidate cached event ids' );
		}
	}
}
