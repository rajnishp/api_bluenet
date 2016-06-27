<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/14/16
 * Time: 11:09 AM
 */

//send sms after successful registration

/*
 *
 * {"root":
	{
  "name" : "raju",
"mobile": "45353",
"email": "",
"type1": "worker",
"address": "asf",
"gps_location": "12.121,21.12",
"device_id": "asdf",
"ref_id": "1",
"emergency_no": "123123",
"native_place": "delhi",
"native_add": "asdf",
"dob": "2014-12-12",
"education": "10",
"experience": "2",
"gender": "M",
"remark": "asfdsadf",
"salary": "1000",
"bonus": "2",
"timings": [
{
	"start_time": "12:12:12",
	"end_time":"21:12:21"
},
{
	"start_time": "12:12:12",
	"end_time":"21:12:21"
}
],
"services": [2,3,4]

    }}
 *
 *
 * */

function generateRandomString($length = 10) {
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

$input = json_decode(file_get_contents("php://input"));

$password = generateRandomString();
	$sql = "INSERT INTO `bluenet_v3`.`users` ( `id` , `name` , `mobile` , `email` , `password` , `type` , `address` , `area` ," .
		" `creation` ,  `gps_location` , `device_id`, `photo` )
				VALUES (NULL ,
				'" . $input->root->name . "',
				'" . $input->root->mobile . "',
				'" . $input->root->email . "',
				'" . $password . "',
				'" . $input->root->type1 . "',
				'" . $input->root->address . "',
				'',
				'" . date("Y-m-d H:i:s") . "',
				'" . $input->root->gps_location . "',
				'" . $input->root->device_id . "',
				'" . $input->root->photo . "'
				);";


	$result = mysqli_query($db_handle, $sql);

	$input->root->user_id = mysqli_insert_id($db_handle);
if($input->root->user_id == 0 ){
	echo "{\"root\":{\"user\":\"\"";

	echo "}}";
	die();
}


$result = mysqli_query($db_handle, "Update users set md5_id = MD5(".$input->root->user_id .") where id = ".$input->root->user_id );

$sql = "INSERT INTO `bluenet_v3`.`user_documents` (`id`,  `user_id`, `adhar_card`, `voter_id`, `driving_license`, `pan_card`)
				VALUES (NULL,
					'" . $input->root->user_id . "',
					 '" . $input->root->adhar_card . "',
					  '" . $input->root->voter_card . "',
					   '" . $input->root->driving_license . "',
						'" . $input->root->pan_card . "');";

$result = mysqli_query($db_handle, $sql);


	/*INSERT INTO `bluenet_v3`.`workers` (`id`, `ref_id`, `user_id`, `status`, `emergency_no`, `native_place`, `native_add`, `dob`, `education`, `experience`, `gender`, `remark`, `salary`, `bonus`) VALUES
	(NULL, '1', '3', 'new', '9090909090', 'delhi', 'asdf', '2016-04-05', '10', '5', 'M', 'afsdv', '1000', '2');*/
	$sql = "INSERT INTO `bluenet_v3`.`workers` (`id`, `ref_id`, `user_id`, `status`, `emergency_no`, `native_place`,
								`native_add`, `dob`, `education`, `experience`, `gender`, `remark`, `salary`, `bonus`)
				VALUES (NULL,
					'" . $input->root->ref_id . "',
					'" . $input->root->user_id . "',
					 'new',
					 '" . $input->root->emergency_no . "',
					  '" . $input->root->native_place . "',
					   '" . $input->root->native_add . "',
						'" . $input->root->dob . "',
						 '" . $input->root->education . "',
						 '" . $input->root->experience . "',
						  '" . $input->root->gender . "',
						   '" . $input->root->remark . "',
							'" . $input->root->salary . "',
							 '" . $input->root->bonus . "');";

	$result = mysqli_query($db_handle, $sql);

	$input->root->id = mysqli_insert_id($db_handle);

	/*
	 * INSERT INTO `bluenet_v3`.`worker_working_timings`
	 * (`id`, `worker_id`, `start_time`, `end_time`, `creation`, `last_update`, `status`, `gps_location`, `device_id`)
	 * VALUES
	 * (NULL, '1', '12:10:38', '09:37:42', CURRENT_TIME(), '2016-04-12 00:00:00', '1', '123.123,321.123', '2asfd');*/

	foreach($input->root->timings as $timing){
		$sql = "INSERT INTO `bluenet_v3`.`worker_working_timings`
					(`id`, `worker_id`, `start_time`, `end_time`, `creation`,  `status`, `gps_location`, `device_id`)
					VALUES (NULL,
					'" . $input->root->id . "',
					 '" . $timing->start_time . "',
					 '" . $timing->end_time . "',
					 '" . date("Y-m-d H:i:s") . "',
					 '1',
					 '" . $input->root->gps_location . "',
				'" . $input->root->device_id . "'
				);";

		$result = mysqli_query($db_handle, $sql);


	}
/*
 *
 * INSERT INTO `bluenet_v3`.`service_worker_mappings`
 * 	(`id`, `worker_id`, `service_id`, `creation`) VALUES ('', '1', '2', CURRENT_TIMESTAMP);
 * */

foreach($input->root->services as $service){
	$sql = "INSERT INTO `bluenet_v3`.`service_worker_mappings`
				(`id`, `worker_id`, `service_id`)
					VALUES ('',
					'" . $input->root->id . "',
					 '" . $service . "'
					 );";

	$result = mysqli_query($db_handle, $sql);


}

print json_encode($input);


$message = "Dear ".$input->root->name.", we have received your registration request. Your username:  "
	. $input->root->mobile . " , Password: " . $password . " at "
	.date("Y-m-d H:i:s") ;

sendSMS($input->root->mobile, $message);
