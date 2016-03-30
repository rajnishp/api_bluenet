<?php

	$input = json_decode(file_get_contents ("php://input"));
	//var_dump($input);

	//$user_id = $_SESSION['user_id'];

	if(!isset($_GET['type'])) {

		$services = mysqli_query($db_handle, "SELECT * FROM `bluenet_v0`.`services` WHERE status = 1 ORDER BY `services`.`priority` ASC ; ");

		for ($servicesArr = array(); $service = mysqli_fetch_assoc($services); $servicesArr[] = $service) ;

		for ($i = 0; $i < count($servicesArr); $i++)
			$servicesArr[$i]["plans"] = json_decode($servicesArr[$i]["plans"]);

		echo "{\"root\":";
		print (json_encode($servicesArr));
		echo "}";
	} else {

		$services = mysqli_query($db_handle, "SELECT DISTINCT `service` FROM `bluenet_v3`.`plans` WHERE service_type = 'monthly';");

		for ($servicesArr = array(); $service = mysqli_fetch_assoc($services); $servicesArr[] = $service["service"]) ;

		echo "{\"root\":";
		print (json_encode($servicesArr));
		echo "}";

	}

?>