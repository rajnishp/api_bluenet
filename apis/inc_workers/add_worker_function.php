<?php

	function addNewWorker ($input, $user_id, $db_handle) {
		//$user_id = $_SESSION['user_id'];
		$user_id = 8;

		$sql = "INSERT INTO bluenethack_v0.workers (`id`, `first_name`, `last_name`, `phone`, `gender`, `area`, `birth_date`, 
												`age`, `education`, `languages`, `min_salary`, `max_salary`, 
												`current_address`, `permanent_address`, `timings`, `work_time`, 
												`varification_status`, `emergency_phone`, `address_proof_name`, 
												`address_proof_id`, `id_proof_name`, `id_proof_id`, `experience`, 
												`remarks`, `service`, `status`, `me_id`)
					VALUES (NULL, 
						'".	$input->root->first_name."', 
						'". $input->root->last_name."', 
						'". $input->root->phone."', 
						'". $input->root->gender."', 
						'". $input->root->area."', 
						'". $input->root->birth_date."', 
						'". $input->root->age."', 
						'". $input->root->education."', 
						'". $input->root->languages."', 
						'". $input->root->min_salary."', 
						'". $input->root->max_salary."', 
						'". $input->root->current_address."', 
						'". $input->root->permanent_address."', 
						'". $input->root->timings."', 
						'". $input->root->work_time."', 
						'". $input->root->verification_status."', 
						'". $input->root->emergency_phone."', 
						'". $input->root->address_proof_name."', 
						'". $input->root->address_proof_id."', 
						'". $input->root->id_proof_name."', 
						'". $input->root->id_proof_id."', 
						'". $input->root->experience."', 
						'". $input->root->remarks."', 
						'". $input->root->service."', 
						'". $input->root->status."', 
						'". $user_id."');";

		$worker = mysqli_query ($db_handle, $sql);
		if(mysqli_connect_errno()){
			//echo "MySql Error";
		}


		$new_worker_id = mysqli_insert_id($db_handle);
		return $new_worker_id;
	}

?>