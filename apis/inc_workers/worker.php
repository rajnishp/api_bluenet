<?php

	$input = json_decode(file_get_contents ("php://input"));

	//$user_id = $_SESSION['user_id'];
	$route = explode("/",$_SERVER[REQUEST_URI]);
	$worker_id = $route['2'];

	$worker = mysqli_query($db_handle, "SELECT * FROM `bluenet_v0`.`workers` WHERE id = $worker_id; ") ;
	$workerRow = mysqli_fetch_assoc($worker);

	echo "{\"root\":";
	print (json_encode($workerRow));
	echo "}";

?>