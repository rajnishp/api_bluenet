<?php 

	session_start();

	$config['host'] = "localhost" ;
	$config['user'] = "root" ;
	$config['password'] = "redhat@11111p" ;
	$config['database'] = "bluenet_v0" ;
	
	$db_handle = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$route = explode("/",$_SERVER[REQUEST_URI]);

	$page = $route[1];
	

	switch ($page) {


		case "login":
			require_once "inc_login/login.php";
				
			break;

		case "client":
			require_once "inc_reg/reg.php";
				
			break;

		case "mobac":
			require_once "mobac/mobac.php";
				
			break;

		case "cem":
			require_once "cem/cem.php";
				
			break;

		case "me":
			require_once "me/me.php";
				
			break;

		default:
			require_once "inc_login/login.php";

			break;
	}


	mysqli_connect($db_handle);

?>