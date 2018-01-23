<?php 
	session_start();
	include( 'class/class-weather.php' );
	$locations = new WeatherLocation();
	if ( ! isset($locations->saved_locations) && $_SERVER['PHP_SELF'] == '/weather.php' ) {
		header( "Location: index.php" );
		die();
	} else if( isset($locations->saved_locations) && $_SERVER['PHP_SELF'] == '/index.php' ) {
		header( "Location: weather.php" );
		die();
	} else if ( (session_status() != '2' && $_SERVER['PHP_SELF'] == 'weather.php' ) ) {
		header( "Location: index.php" );
		die();
	}
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	} else if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if ( ! empty($_SERVER['REMOTE_ADDR'] ) ) {
		$ip_address = $_SERVER['REMOTE_ADDR'];
	}
	$ip_data_response = json_decode( file_get_contents( "http://www.geoplugin.net/json.gp?ip=" . $ip_address ) );
	$ip_country = $ip_data_response->geoplugin_countryCode;
?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="src/js/jquery-3.3.1.min.js"></script>
	<script src="src/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="src/css/bootstrap.min.css">
	<script src="src/js/main.js"></script>
	<link rel="stylesheet" type="text/css" href="src/css/style.css">
</head>