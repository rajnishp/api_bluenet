<?php


	json_decode(file_get_contents ("php://input"));

	$user = mysqli_query ($db_handle, "SELECT * FROM user WHERE email= $email AND password = $password AND employee_type = $employee_type;");
	if(mysqli_connect_errno()){
	}

	var_dump($user);

?>