<?php

	$input = json_decode(file_get_contents ("php://input"));
	var_dump($input);
	
	foreach ($input->root->contacts as $key => $contact) {
		
		$sql = "INSERT INTO `mobac`.`contacts` (`id`, `client_id`, `name`, `mobile`, `email`, `location`) 
					VALUES (NULL, 
						'".	$contact->client_id."', 
						'".	$contact->name."', 
						'".	$contact->mobile."', 
						'". $contact->email."', 
						'". $contact->location."');";

		$user = mysqli_query ($db_handle, $sql);


	}

	

?>