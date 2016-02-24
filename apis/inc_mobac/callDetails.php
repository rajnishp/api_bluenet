<?php

	$input = json_decode(file_get_contents ("php://input"));
	var_dump($input);

	foreach ($input->root->callDetails as $key => $callDetail) {
		
		$sql = "INSERT INTO `mobac`.`call_details` (`id`, `client_id`, `second_party`, `call_duration`, `creation`, `type`, `location`) 
					VALUES (NULL, 
						'".	$callDetail->client_id."',
						'".	$callDetail->second_party."', 
						'".	$callDetail->call_duration."', 
						'". $callDetail->creation."',
						'". $callDetail->type."', 
						'". $callDetail->location."');";

		$user = mysqli_query ($db_handle, $sql);
		if(mysqli_connect_errno()){
			/* send 500 html header*/
			internalServerError("Error description: " . mysqli_error($db_handle));
			echo("Error description: " . mysqli_error($db_handle));
			die();
		}

	}

	

?>