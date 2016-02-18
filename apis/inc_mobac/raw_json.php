<?php

	$input = json_decode(file_get_contents ("php://input"));
	var_dump($input);


	$type = $_GET['type'];
	
	foreach ($input->root->raw as $key => $rawJson) {
		
		$sql = "INSERT INTO `mobac`.`raw_json` (`id`, `device_id`, `raw`, `type`, `location`)
					VALUES (NULL, 
						'".	$input->root->device_id."',
						'".	json_encode($rawJson)."',
						'".	$type."',
						'". $input->root->gps_location."'
						);";

		$user = mysqli_query ($db_handle, $sql);
		if(mysqli_connect_errno()){
			// send 500 html header
		}

	}


?>