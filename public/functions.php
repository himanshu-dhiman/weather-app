<?php
	include('config/constants.php');
	$db_connection = mysqli_connect( DB_HOST, DB_USER, DB_PASS );
	mysqli_select_db($db_connection, DB_NAME);

	function add_location() {
		if ( ! isset($_POST['country']) || ! isset($_POST['name']) || ! isset($_POST['link']) ) {
			$response['status'] = 'error';
			return $response;
		} else {
			$country = $_POST['country'];
			$link = $_POST['link'];
			$name = $_POST['name'];
			if( ! $GLOBALS['db_connection'] ) {
				$response['status'] = 'error';
				return $response;
			}
			$add_query = "INSERT INTO location (name, country, link) VALUES ('$name', '$country', '$link')";
			$add_status = mysqli_query($GLOBALS['db_connection'], $add_query);
			if(! $add_status ) {
				$response['status'] = 'error';
				return $response; 
			}
			mysqli_close($GLOBALS['db_connection']);
			$response['status'] = 'success';
			return $response;
		}
	}

	function del_location() {
		if ( ! isset($_POST['id'])) {
			$response['status'] = 'error';
			return $response;
		} else {
			$id = $_POST['id'];
			if( ! $GLOBALS['db_connection'] ) {
				$response['status'] = 'error';
				return $response;
			}
			$del_query = "DELETE FROM location WHERE id='$id'";
			$delete_status = mysqli_query($GLOBALS['db_connection'], $del_query);
			if(! $delete_status ) {
				$response['status'] = 'error';
				return $response; 
			}
			mysqli_close($GLOBALS['db_connection']);
			$response['status'] = 'success';
			return $response;
		}
	}

	