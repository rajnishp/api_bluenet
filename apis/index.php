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

$config['host'] = "localhost";
$config['user'] = "root";
$config['password'] = "redhat@11111p";
$config['database'] = "bluenethack_v0";

$method = $_SERVER['REQUEST_METHOD'];

$db_handle = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function internalServerError($error)
{
	header('HTTP/1.1 500 Internal Server Error');
	$emailIds = array("rahul_lahoria@yahoo.com", "pwnpnwr785@gmail.com", "vikas.niper2012@gmail.com", "kumar.anil8892@yahoo.com");
	foreach ($emailIds as $to)
		sendMail($to, "Alert! error occurred in apis", $error);
}

function sendMail($to, $subject, $message)
{

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <blueteam.requests@blueteam.in>' . "\r\n";
	//$headers .= 'Cc: myboss@example.com' . "\r\n";

	mail($to, $subject, $message, $headers);
}

$fist = explode("?", $_SERVER[REQUEST_URI]);
$route = explode("/", $fist[0]);
//var_dump($route);die();

$page = $route[1];


switch ($page) {


	case "client":
		require_once "inc_reg/reg.php";

		break;

	case "feedback":
		require_once "inc_client/feedback.php";

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
		if ($method == "POST") {
			require_once "inc_service_request/post.php";
		} else
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

	case "check-mobile":
		require_once "app_rec/check_mobile.php";
		break;

	case "login":
		require_once "app_rec/login.php";
		break;

	case "work":
		if ($method == "POST")
			require_once "app_rec/postWork.php";
		else
			require_once "app_rec/getWork.php";
		break;

	default:
        internalServerError("Error description: " . json_encode($_SERVER));
        die();

		break;
}


mysqli_close($db_handle);

?>
