<?php 

	session_start();

	// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

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
			switch ($route[2]) {

				case 'contacts':
					require_once "inc_mobac/contacts.php";
					break;

				case 'messages':
					require_once "inc_mobac/messages.php";
					break;

				case 'callDetails':
					require_once "inc_mobac/callDetails.php";
					break;
				
				default:
					echo "Wrong Way!!! Contact dev@blueteam.in";

					break;
			}
			
				
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


	mysqli_close($db_handle);

?>