<?php

	$input = json_decode(file_get_contents ("php://input"));
	var_dump($input);

	$sql = "INSERT INTO clients (id, name, email, password, mobile, location)
				VALUES (NULL, 
					'".	$input->root->name."', 
					'". $input->root->email."', 
					'". $input->root->password."', 
					'". $input->root->mobile."', 
					'". $input->root->gps_location."');";

	$user = mysqli_query ($db_handle, $sql);
	if(mysqli_connect_errno()){
		/* send 500 html header*/
		internalServerError("Error description: " . mysqli_error($db_handle));
		echo("Error description: " . mysqli_error($db_handle));
		die();
		internalServerError("Error description: " . mysqli_error($db_handle));
		echo("Error description: " . mysqli_error($db_handle));
		die();
	}

	

?>