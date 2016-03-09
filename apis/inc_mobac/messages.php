<?php

	$input = json_decode(file_get_contents ("php://input"));
	var_dump($input); 
	
	foreach ($input->root->messages as $key => $message) {
		
		$sql = "INSERT INTO `mobac`.`messages` (`id`, `client_id`, `from_to`, `message_text`, `creation`, `type`, `location`) 
					VALUES (NULL, 
						'".	$message->client_id."', 
						'".	$message->from_to."', 
						'".	$message->message_text."', 
						'". $message->creation."',
						'". $message->type."', 
						'". $message->location."');";

		$user = mysqli_query ($db_handle, $sql);


	}

	

?>