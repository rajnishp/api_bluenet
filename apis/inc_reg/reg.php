<?php

	$input = json_decode(file_get_contents ("php://input"));
	

	$sql = "INSERT INTO bluenet_v0.clients (id, name, email, password, mobile, location) 
				VALUES (NULL, 
					'".	$input->root->name."', 
					'". $input->root->email."', 
					'". $input->root->password."', 
					'". $input->root->mobile."', 
					'". $input->root->location."');";

	$user = mysqli_query ($db_handle, $sql);
	if(mysqli_connect_errno()){
		// send 500 html header
	}

	

?>