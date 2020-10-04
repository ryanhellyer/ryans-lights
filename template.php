<!DOCTYPE html>
<html lang="en-NZ">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<title>Ryan's lights</title>
	<link rel='stylesheet' href='style.css' type='text/css' media='all' />
</head>
<body>

<h1>Good <?php

if ( 0 < date( 'H' ) && 12 > date( 'H' ) ) {
	echo 'morning';
} else if ( 12 < date( 'H' ) && 18 > date( 'H' ) ) {
	echo 'afternoon';
} else if ( 18 < date( 'H' ) && 24 > date( 'H' ) ) {
	echo 'evening';
}

?>!</h1>
<div id="temperature"><?php

	echo absint( $temperature );
	echo '°';
	echo ' <span>' . esc_html( $description ). '</span>';

?></div>

<?php

if ( isset( $joke ) ) {
	echo '<p>' . esc_html( $joke ) . '</p>';
}

?>

<h2>Devices</h2>
<ul><?php

foreach ( $devices as $device ) {
	$device_id = $device['deviceId'];
	$alias     = $device['alias'];

	// Skip if no device state is found.
	if ( ! isset( $device_states[ $device_id ] ) ) {
		continue;
	}

	if ( 0 === $device_states[ $device_id ] ) {
		$state = 'off';
	} else {
		$state = 'on';
	}

	echo '<li class="' . esc_attr( 'state-' . $state ) . '"><a href="' . esc_attr( '/?device_id=' . $device_id . '&state=' . $state ) . '">' . esc_html( $alias ) . '</a></li>';
}

?></ul>

</body>
</html>