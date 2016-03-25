<?php

$input = json_decode(file_get_contents("php://input"));
var_dump($input);


/*INSERT INTO
 *	`bluenet_v3`.`service_request`
 * 			(`id`, `user_id`, `mobile`, `service`, `service_type`, `salary`, `remarks`, `worker_gender`,
 * 					`user_cem_id`, `creation`, `last_update`, `gps_location`, `device_id`)
 * 			VALUES
 *			(NULL, '2', '8989898989', 'maid', 'monthly', '8900', 'safdas', 'male', '3', '2016-03-07 00:00:00',
 * 				CURRENT_TIMESTAMP, '31.123,1231,31', '2asfd');
 * INSERT INTO
 * `bluenet_v3`.`timings`
 * (`id`, `service_request_id`, `start_time`, `end_time`, `creation`, `last_update`, `status`, `gps_location`, `device_id`)
 * VALUES
 * (NULL, '1', CURRENT_TIME(), CURRENT_TIME(), '2016-03-07 00:00:00', '2016-03-07 07:17:18', '0', '132.132,123.312', 'aerf');
 * */


$sql = "INSERT INTO service_request (`id`, `name`, `mobile`, `requirements`, `gender`, `timings`,
													`min_salary`, `max_salary`, `address`, `area`, `remarks`, `worker_area`,
													`work_time`, `created_time`, `date`, `user_id`, `priority`)
				VALUES (NULL,
					'".	$input->root->name."',
					'" . $input->root->mobile . "',
					'" . $input->root->requirements . "',
					'" . $input->root->gender . "',
					'" . $input->root->timings . "',
					'" . $input->root->min_salary . "',
					'" . $input->root->max_salary . "',
					'" . $input->root->address . "',
					'" . $input->root->area . "',
					'" . $input->root->remarks . "',
					'" . $input->root->worker_area . "',
					'" . $input->root->work_time . "',
					'". date("Y-m-d")."',
					'" . $input->root->date . "',

					'". $input->root->user_id."',
					'". $input->root->priority."');";
echo "query: " . $sql . "\n";
$service_request = mysqli_query($db_handle, $sql);


$emailIds = array("rahul_lahoria@yahoo.com", "pwnpnwr785@gmail.com", "vikas.niper2012@gmail.com", "kumar.anil8892@yahoo.com","neelamdubey1988@gmail.com");
foreach ($emailIds as $to)
	sendMail($to, "mobile app service requiest", json_encode($input));

/*
 *
 * {"root":
 * 	{
 * 		"name":"Rahul Lahoria",
 * 		"mobile":"9599075955",
 * 		"location":"null,null",
 * 		"user_id":"20",
 * 		"requirements":"maid",
 * 		"service_type": "monthly",
 * 		"remarks":"Monthly this is request by mobile app",
 * 		"start_time":"19:00:00",
 * 		"end_time":"21:00:00",
 * 		"address":"Test",tc
 * 		"priority":"3"}} tc
 * */
$sql = "INSERT INTO `bluenet_v3`.`service_request`
				(`id`, `user_id`, `mobile`, `service`, `service_type`, `salary`, `remarks`, `worker_gender`,
					`user_cem_id`, `creation`,  `gps_location`, `device_id`, `address`, `priority`, `startingDateTime`)
				VALUES
				(NULL, '".	$input->root->user_id."',
						'".	$input->root->mobile."',
						'".	$input->root->requirements."',
						'".	$input->root->service_type."',
						'',
						'".	$input->root->remarks."',
						'',
						'10',
						'".date("Y-m-d H:i:s")."',
						'".	$input->root->location."',
						'".	$input->root->device_id."',
						'".	$input->root->address."',
						'".	$input->root->priority."',
						'".	date('Y-m-d H:i:s', strtotime($input->root->start_datatime))."');";

$service_request = mysqli_query($db_handle, $sql);

$input->root->sr_id = mysqli_insert_id($db_handle);

$sql = "INSERT INTO `bluenet_v3`.`timings`
			(`id`, `service_request_id`, `start_time`, `end_time`, `creation`, `status`, `gps_location`, `device_id`)
			VALUES (NULL,
				'".	$input->root->sr_id."',
				 '".	$input->root->start_time."',
				  '".	$input->root->end_time."',
				   '".date("Y-m-d H:i:s")."',
				     '0',
				     '".	$input->root->location."',
				      '".	$input->root->device_id."'
				      );";

/*
 * Dear Customer, your request for {{}} has been received successfully at {{time}}, request will be processed shortly.
 * Dear Customer, we have received payment of {{amount}} for sr_id by {{cem_name}} ({{cem_mobile}}) {{cem_id}} at {{time}}. Txn. ID: {{id}}
 * */
$service_request = mysqli_query($db_handle, $sql);

$message = "Dear Customer, your request for "
			.$input->root->requirements
			." has been received successfully at "
			.date("Y-m-d H:i:s").", request will be processed shortly.";
sendSMS($input->root->mobile, $message);
/*
	$sql = "SELECT * FROM `area`;";
	$area_array = mysqli_query ($db_handle, $sql);


		if (mysqli_num_rows($area) !=0 ) {
			//$area->name == $input->root->area
			foreach ($area_array as $key => $area) {
				$area_id = $area -> id;
				$sql = "INSERT INTO sr_area (`id`, `sr_id`)
					VALUES ('".$area_id."',
						'". $new_sr_id."');";

				//id: area_id, sr_id: service_request_id

				$sr_area = mysqli_query ($db_handle, $sql);
				if(mysqli_connect_errno()){
					// send 500 html header internalServerError("Error description: " . mysqli_error($db_handle)); echo("Error description: " . mysqli_error($db_handle));die();
				}
			}
		}
		else {
			$sql = "INSERT INTO area (`id`, `name`)
			VALUES (NULL,
				'". $input->root->area."');";

			$area = mysqli_query ($db_handle, $sql);
			if(mysqli_connect_errno()){
				// send 500 html header internalServerError("Error description: " . mysqli_error($db_handle)); echo("Error description: " . mysqli_error($db_handle));die();
			}


			$sql = "INSERT INTO sr_area (`id`, `sr_id`)
				VALUES (NULL,
					'". $new_sr_id."');";

			//id: area_id, sr_id: service_request_id

			$sr_area = mysqli_query ($db_handle, $sql);
			if(mysqli_connect_errno()){
				// send 500 html header internalServerError("Error description: " . mysqli_error($db_handle)); echo("Error description: " . mysqli_error($db_handle));die();
			}
		}






	$sql = "INSERT INTO skill_name (`id`, `name`)
				VALUES (NULL,
					'". $input->root->name."');";

	//id: skill_id, name: skill_name

	$skill_name = mysqli_query ($db_handle, $sql);
	if(mysqli_connect_errno()){
		/// send 500 html header internalServerError("Error description: " . mysqli_error($db_handle)); echo("Error description: " . mysqli_error($db_handle));die();
	}


	$sql = "INSERT INTO skills (`id`, `user_id`, `skill_id`, `creation_date`, `status`, `type`, `employee_id`)
				VALUES (NULL,
					'". $input->root->user_id."',
					'". $input->root->skill_id."',
					'". $input->root->created_date."',
					'". $input->root->status."',
					'". $input->root->type."',
					'". $input->root->employee_id."');";

	//

	$skills = mysqli_query ($db_handle, $sql);
	if(mysqli_connect_errno()){
		// send 500 html header internalServerError("Error description: " . mysqli_error($db_handle)); echo("Error description: " . mysqli_error($db_handle));die();
	}*/


?>