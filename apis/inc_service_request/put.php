<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/7/16
 * Time: 2:53 PM
 */


$input = json_decode(file_get_contents("php://input"));
//var_dump($input);

/*
 * INSERT INTO `bluenet_v3`.`worker_client_logs`
 * (`id`, `service_request_id`, `start_time`, `end_time`, `creation`, `user_worker_id`, `device_id`, `gps_location`)
 * VALUES ('', '1', CURRENT_TIME(), CURRENT_TIME(), CURRENT_TIMESTAMP, '1', 'afdas', '123.123,321.123');
 *
 *
 *
 * */

if($input->root->key == "status")
  $set = "`status` = '" . $input->root->value . "'";

if($input->root->key == "new_cem_id")
    $set = "`user_cem_id` = '" . $input->root->value . "'";

if($input->root->key == "address")
    $set = "`address` = '" . $input->root->value . "', remarks = '" . $input->root->remark . "'";

$sql = "UPDATE `bluenet_v3`.`service_request`
                SET ".$set."
                WHERE `service_request`.`id` = " . $input->root->sr_id . ";";

if($input->root->key == "user_worker_id") {
    $sql = "INSERT INTO
                `bluenet_v3`.`worker_customer_match`
                  (`id`, `user_worker_id`, `service_request_id`, `type`, `creation`)
                  VALUES
                  (NULL,
                  '".$input->root->value."',
                  '" . $input->root->sr_id . "',
                  'parmanent',
                  '".date("Y-m-d H:i:s")."'
                  );";
}




//echo "query: " . $sql . "\n";
$service_request = mysqli_query($db_handle, $sql);

//mysqli_insert_id($con)

$input->root->id = mysqli_insert_id($db_handle);

print json_encode($input);