<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/14/16
 * Time: 11:09 AM
 */
$input = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO `bluenet_v3`.`payments`
                      (`id`, `service_request_id`, `amount`, `user_cem_id`, `device_id`, `gps_location`, `user_id`, `check_no`)
                      VALUES (NULL,
                      '" . $input->root->sr_id . "',
                      '" . $input->root->amount . "',
                       '" . $input->root->user_id . "',
                       '" . $input->root->device_id . "',
                        '" . $input->root->gps_location . "',
                          '" . $input->root->customer_id . "',
                          '" . $input->root->check_no . "');";
$result = mysqli_query($db_handle, $sql);

$input->root->id = mysqli_insert_id($db_handle);

print json_encode($input);

$result = mysqli_query($db_handle, "SELECT  `name` , `mobile` , `email` , `type` , `address` , `area` ," .
    " `creation` ,  `gps_location` , `device_id`  FROM `bluenet_v3`.`users` WHERE id = " . $input->root->customer_id . "; ");

$details = mysqli_fetch_assoc($result);

$sql = "UPDATE `bluenet_v3`.`service_request` SET `user_cem_id` = '" . $input->root->user_id  . "' WHERE `service_request`.`id` = " . $input->root->sr_id . ";";
$result = mysqli_query($db_handle, $sql);

$message = "Dear ".$details['name'].", we have received payment of "
            . $input->root->amount . " Rs for " . $input->root->sr_id . " by "
            . $input->root->name
            . "(" . $input->root->mobile . ") EMP_ID: BT-2015-"
            . $input->root->user_id . " at "
            .date("Y-m-d H:i:s").". Txn. ID: BT-".date("YmdHis-").$input->root->id ;

sendSMS($details['mobile'], $message);
sendSMS($input->root->mobile, $message);
