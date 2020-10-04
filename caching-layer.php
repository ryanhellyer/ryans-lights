<?php

/**
 * Get cached data.
 *
 * @param string $key The cache key.
 * @return array|string The cache result.
 */
function get_cache( $key ) {
	$data = file_get_contents( '../cache/' . $key . '.txt' );
	$data = explode( '|', $data );
	if ( isset( $data[0] ) && isset( $data[1] ) && isset( $data[2] ) ) {
		$last_time = $data[0];
		$result    = $data[1];
		$expiry    = $data[2];

		if ( ( $last_time + $expiry ) > time() ) {

			// If data is an array, the decode it first.
			if ( is_array( json_decode( $result, true ) ) ) {
				$result = json_decode( $result, true );
			}

			return $result;
		}
	}

	return null;
}

/**
 * Update cached data.
 *
 * @param string $key The cache key.
 * @param string $data The data to store.
 * @param int $expiry The expiry time in seconds.
 */
function update_cache( $key, $data, $expiry ) {

	if ( is_array( $data ) ) {
		$data = json_encode( $data );
	}

	file_put_contents( '../cache/' . $key . '.txt', time() . '|' . $data . '|' . $expiry );
}
