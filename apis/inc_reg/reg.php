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

$sql = "INSERT INTO `bluenet_v3`.`users` ( `id` , `name` , `mobile` , `email` , `password` , `type` , `address` , `area` ," .
	" `creation` ,  `gps_location` , `device_id` )
			VALUES (NULL ,
			'" . $input->root->name . "',
			'" . $input->root->mobile . "',
			'" . $input->root->email . "',
			'" . $input->root->password . "',
			'customer',
			'',
			'',
			'" . date("Y-m-d H:i:s") . "',
			'" . $input->root->gps_location . "',
			'" . $input->root->device_id . "'
			);";

$result = mysqli_query($db_handle, $sql);

$input->root->id = mysqli_insert_id($db_handle);

print json_encode($input);

?>