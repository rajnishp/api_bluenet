<?php

$input = json_decode(file_get_contents("php://input"));
//var_dump($input);


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
					'" . $input->root->name . "',
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
					'" . date("Y-m-d") . "',
					'" . $input->root->date . "',

					'" . $input->root->user_id . "',
					'" . $input->root->priority . "');";
echo "query: " . $sql . "\n";
$service_request = mysqli_query($db_handle, $sql);




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
				(`id`, `user_id`, `name`, `mobile`, `service`, `service_type`, `salary`, `remarks`, `worker_gender`,
					`creation`,  `gps_location`, `device_id`, `address`, `priority`, `startingDateTime`)
				VALUES
				(NULL, '" . $input->root->user_id . "',
						'" . $input->root->name . "',
						'" . $input->root->mobile . "',
						'" . $input->root->requirements . "',
						'" . $input->root->service_type . "',
						'',
						'" . $input->root->remarks . "',
						'',
						'" . date("Y-m-d H:i:s") . "',
						'" . $input->root->location . "',
						'" . $input->root->device_id . "',
						'" . $input->root->address . "',
						'" . $input->root->priority . "',
						'" . date('Y-m-d H:i:s', strtotime($input->root->start_datatime)) . "');";

$service_request = mysqli_query($db_handle, $sql);

$input->root->sr_id = mysqli_insert_id($db_handle);

$sql = "INSERT INTO `bluenet_v3`.`timings`
			(`id`, `service_request_id`, `start_time`, `end_time`, `creation`, `status`, `gps_location`, `device_id`)
			VALUES (NULL,
				'" . $input->root->sr_id . "',
				 '" . $input->root->start_time . "',
				  '" . $input->root->end_time . "',
				   '" . date("Y-m-d H:i:s") . "',
				     '0',
				     '" . $input->root->location . "',
				      '" . $input->root->device_id . "'
				      );";

/*
 * Dear Customer, your request for {{}} has been received successfully at {{time}}, request will be processed shortly.
 * Dear Customer, we have received payment of {{amount}} for sr_id by {{cem_name}} ({{cem_mobile}}) {{cem_id}} at {{time}}. Txn. ID: {{id}}
 * */
$service_request = mysqli_query($db_handle, $sql);

$result = mysqli_query($db_handle, "SELECT  `name` , `mobile` , `email` , `type` , `address` , `area` ," .
    " `creation` ,  `gps_location` , `device_id`  FROM `bluenet_v3`.`users` WHERE id = " . $input->root->user_id . "; ");

$details = mysqli_fetch_assoc($result);

$emailMessage = "Dear Customer,<br/><br/> your request for "
    . $input->root->requirements
    . " has been received successfully at "
    . date("Y-m-d H:i:s") . ", request will be processed shortly." . "
<br/><br/><br/><br/><br/>
For any clarifications contact us at 95990 75355.
<br/><br/>
This service is a part of our constant endeavor to deliver Superior Customer Service Experience to our valued customers. At BlueTeam, we value your feedback. Please write to us at feeds@blueteam.in, contact your Client Engagement Manager (CEM).
If you would like to view any other details regarding your account, please login to our mobile app. This is a system generated message. Please do not reply to this e-mail.";

if ($input->root->user_type == "customer" || !isset($input->root->user_type))
    sendMail($details['email'], "BlueTeam: Request received successfully for " . $input->root->requirements, $emailMessage);


$message = "Dear Customer, your request for "
    . $input->root->requirements . "( SR_ID:" . $input->root->sr_id . ")"
    . " has been received successfully at "
    . date("Y-m-d H:i:s") . ", request will be processed shortly.";


if ($input->root->user_type == "customer" || !isset($input->root->user_type))
    sendSMS($input->root->mobile, $message);

$emailIds = array("rahul_lahoria@yahoo.com", "mamtasauda91@gmail.com","pwnpnwr785@gmail.com", "vikas.niper2012@gmail.com", "kumar.anil8892@yahoo.com", "neelamdubey1988@gmail.com");
foreach ($emailIds as $to)
    sendMail($to, "mobile app service request", json_encode($input));


?>