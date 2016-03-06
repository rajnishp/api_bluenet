<?php


	$input = json_decode(file_get_contents ("php://input"));
	
	var_dump($input);
	
	addNewWorker ($input, $user_id, $db_handle);

?>