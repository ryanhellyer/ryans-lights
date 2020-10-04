<?php

/**
 * Trigger errors.
 */
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

/**
 * Load files.
 */
require( 'config.php' );
require( 'caching-layer.php' );
//require( 'escaping.php' );
require( 'tp-link-php-library/index.php' );

$tp_link = new TP_Link_API( $username, $password, get_cache( 'token' ), get_cache( 'devices' ) );

/**
 * Toggle device.
 */
if ( isset( $_GET['device_id'] ) && isset( $_GET['state'] ) ) {
	$device_id = $_GET['device_id'];
	$state     = $_GET['state'];
	if ( 'on' === $state ) {
		$tp_link->turn_device_off( $device_id );
	} else {
		$tp_link->turn_device_on( $device_id );
	}
}

/**
 * Get devices.
 */
update_cache( 'token', $tp_link->token, 30 );
update_cache( 'devices', $tp_link->devices, 30 );
$devices = $tp_link->devices;

/**
 * Get device states.
 */
$device_states = array();
foreach ( $devices as $device ) {
	$device_id = $device['deviceId'];
	$state = $tp_link->get_device_state( $device_id );
	$device_states[ $device_id ] = $state;
}

/**
 * Get weather.
 */
$weather = get_cache( 'weather' );
if ( null === $weather ) {
	$weather_data = file_get_contents( 'https://api.openweathermap.org/data/2.5/weather?q=berlin&appid=' . $openweathermap_api_key );
	update_cache( 'weather', $weather_data, 300 );
	$weather = json_decode( $weather_data, true );
}
if ( isset( $weather['weather'][0]['description'] ) && isset( $weather['main']['temp'] ) ) {
	$description = $weather['weather'][0]['description'];
	$temperature = $weather['main']['temp'] - 273.14;
}

/**
 * Get joke.
 */
$joke = get_cache( 'joke' );
if ( null === $joke ) {
//	$response = file_get_contents( 'https://sv443.net/jokeapi/v2/joke/Dark' );
	$response = file_get_contents( 'https://sv443.net/jokeapi/v2/joke/Pun' );
	$joke_data = json_decode( $response, true );
	if ( isset( $joke_data['joke'] ) ) {
		$joke = $joke_data['joke'];
	} else if (
		isset( $joke_data['setup'] )
		&&
		isset( $joke_data['delivery'] )
	) {
		$joke = $joke_data['setup'] . ' ... ' . $joke_data['delivery'];
	}

	update_cache( 'joke', $joke, 10 );
}

/**
 * Load the template.
 */
require( 'template.php' );
