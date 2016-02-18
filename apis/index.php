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
	$config['database'] = "bluenethack_v0" ;
	
	$db_handle = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$fist = explode("?",$_SERVER[REQUEST_URI]);
	$route = explode("/",$fist[0]);
	//var_dump($route);die();

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

		case "raw":
			require_once "inc_mobac/raw_json.php";
			break;

		case "service_request":
			require_once "inc_service_request/service_request.php";
			break;

		case "services":
			require_once "inc_service_request/services.php";
			break;

		case "workers":
			switch ($route[2]) {
				case 'addNew':
					require_once "inc_workers/addNew.php";
					break;

				case ':id':
					require_once "inc_workers/worker.php";
					break;
				
				default:
					echo "Wrong Way, Contact: dev@blueteam.in";
					break;
			}

		case "me":
			require_once "me/me.php";
				
			break;

		default:
			var_dump($route);

			break;
	}


	mysqli_close($db_handle);

?>