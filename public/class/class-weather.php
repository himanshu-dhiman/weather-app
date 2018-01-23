<?php

include('config/constants.php');
$db_connection = mysqli_connect( DB_HOST, DB_USER, DB_PASS );
mysqli_select_db($db_connection, DB_NAME);
/**
* Class for WeatherLocation Management
*/
class WeatherLocation
{
	public $saved_locations;

	function __construct()
	{	
		$this->saved_locations = $this->get_locations();
	}

	function get_locations() {
		$api_url = "http://api.wunderground.com/api/".WEATHER_API_KEY."/conditions";
		if( ! $GLOBALS['db_connection'] ) {
			return NULL;
		}
		$get_locations_query = "SELECT * FROM location";
		$queried_locations = mysqli_query($GLOBALS['db_connection'], $get_locations_query);
		if( ! $queried_locations ) {
			$create_table_query = "
				CREATE TABLE IF NOT EXISTS location (
				id int(11) AUTO_INCREMENT,
				name varchar(255) NOT NULL UNIQUE,
				country varchar(255) NOT NULL,
				link varchar(255) NOT NULL,
				PRIMARY KEY  (id)
			)";
			$result = mysqli_query($GLOBALS['db_connection'], $create_table_query);
			return NULL;
		}
		
		while($single_location = mysqli_fetch_array($queried_locations)) {
			$location_json = file_get_contents($api_url.$single_location['link'].".json");
			$parsed_location_json = json_decode($location_json);
			$locations_data[] = array(
				'id' => $single_location['id'],
				'full_name' => $parsed_location_json->current_observation->display_location->full,
				'temp_c' => $parsed_location_json->current_observation->temp_c,
				'temp_f' => $parsed_location_json->current_observation->temp_f,
				'country' => $parsed_location_json->current_observation->display_location->country,
				'city' => $parsed_location_json->current_observation->display_location->city,
				'state' => $parsed_location_json->current_observation->display_location->state_name,
				'weather' => $parsed_location_json->current_observation->weather,
				'icon_url' => $parsed_location_json->current_observation->icon_url
			);
		}
		if(isset($locations_data)) {	
			mysqli_close($GLOBALS['db_connection']);
			return $locations_data;
		} else {
			return NULL;
		}
	}
}