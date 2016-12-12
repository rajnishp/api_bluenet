<?php

$input = json_decode(file_get_contents("php://input"));
//var_dump($input);

$sql = "INSERT INTO clients (id, name, email, password, mobile, location)
				VALUES (NULL,
					'" . $input->root->name . "',
					'" . $input->root->email . "',
					'" . $input->root->password . "',
					'" . $input->root->mobile . "',
					'" . $input->root->gps_location . "');";

$user = mysqli_query($db_handle, $sql);

$serviceProviderId = 0;
if($input->root->coupon != ""){

    $arrCoupon = explode("#",$input->root->coupon);
    $serviceProviderId = $arrCoupon[1];
}

$sql = "INSERT INTO `bluenet_v3`.`users` ( `id` , `name` , `mobile` , `email` , `password` , `type` ,`sp_id`, `address` , `area` ," .
    " `creation` ,  `gps_location` , `device_id` )
			VALUES (NULL ,
			'" . $input->root->name . "',
			'" . $input->root->mobile . "',
			'" . $input->root->email . "',
			'" . $input->root->password . "',
			'customer',
			'" . $serviceProviderId . "',
			'',
			'',
			'" . date("Y-m-d H:i:s") . "',
			'" . $input->root->gps_location . "',
			'" . $input->root->device_id . "'
			);";

$result = mysqli_query($db_handle, $sql);

$input->root->id = mysqli_insert_id($db_handle);

$result = mysqli_query($db_handle, "Update users set md5_id = MD5(".$input->root->id .") where id = ".$input->root->id );


if ($input->root->id == 0) {
    internalServerError("Error description: " . json_encode($_SERVER));
    die();
}

$emailIds = array("rahul_lahoria@yahoo.com", "pwnpnwr785@gmail.com", "vikas.niper2012@gmail.com", "kumar.anil8892@yahoo.com","neelamdubey1988@gmail.com");
foreach ($emailIds as $to)
    sendMail($to, "User got registered", json_encode($input));

if($input->root->coupon != ""){

    $arrCoupon = explode("#",$input->root->coupon);

    $result = mysqli_query($db_handle, "SELECT  `mobile_no` FROM blueteam_service_providers.`service_providers`
                WHERE id = " . $arrCoupon[1] . "; ");

    $details = mysqli_fetch_assoc($result);
    sendSMS($details['mobile_no'], "100Rs got added to your account,\nPlease give 100Rs discount to \n".$input->root->name ." ".$input->root->mobile);


}

print json_encode($input);

?>