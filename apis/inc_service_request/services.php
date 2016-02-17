<?php

	$input = json_decode(file_get_contents ("php://input"));
	//var_dump($input);

	//$user_id = $_SESSION['user_id'];
	
	$services = mysqli_query($db_handle, "SELECT * FROM `bluenet_v0`.`services` WHERE 1; ") ;

	for($servicesArr = array(); $service = mysqli_fetch_assoc($services); $servicesArr[] = $service);

	for ($i=0; $i < count($servicesArr) ; $i++) 
		$servicesArr[$i]["plans"] = json_decode($servicesArr[$i]["plans"]);

	echo "{\"root\":";
	print (json_encode($servicesArr));
	echo "}";

?>