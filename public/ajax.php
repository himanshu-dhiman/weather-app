<?php 
	require 'functions.php';

	if(isset($_POST['action']))	{
		switch ($_POST['action']) {
			case 'add_location': 	$status = add_location();
									echo json_encode($status);
									break;

			case 'del_location': 	$status = del_location();
									echo json_encode($status);
									break;
			default : 	echo "Invalid...";
						break;
		}
	}