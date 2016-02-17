<?php

	$input = json_decode(file_get_contents ("php://input"));
	//var_dump($input);

	//$user_id = $_SESSION['user_id'];
	$user_id = 6;
	$route = explode("/",$_SERVER[REQUEST_URI]);
	$status = $route['2'];
	
	$service_requests = mysqli_query($db_handle, "SELECT sr.* FROM service_request as sr WHERE ".$condition." ; ") ;

	$rows = array();

 	
	echo "{\"root\":";
	print json_encode($rows);
	echo "}";


?>