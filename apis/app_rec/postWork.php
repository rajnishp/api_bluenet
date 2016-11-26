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
if ($input->root->start_time) {
    $startTime = date('H:i:s', strtotime($input->root->start_time));
    $endTime = null;


    $sql = "INSERT INTO `bluenet_v3`.`worker_client_logs`
                (`id`, `service_request_id`, `start_time`, `end_time`, `creation`, `user_worker_id`, `device_id`, `gps_location`)
				VALUES (NULL,
					'" . $input->root->service_request_id . "',
					'" . $startTime . "',
					'" . $endTime . "',
					'" . date("Y-m-d H:i:s") . "',
					'" . $route[2] . "',
					'" . $input->root->device_id . "',
					'" . $input->root->gps_location . "');";

} else {
    $endTime = date('H:i:s', strtotime($input->root->end_time));
    $id = $input->root->id;
    $sql = "UPDATE `bluenet_v3`.`worker_client_logs` SET `end_time` = '" . $endTime . "' WHERE `worker_client_logs`.`id` = " . $id . ";";
}
//echo "query: " . $sql . "\n";
$service_request = mysqli_query($db_handle, $sql);

//mysqli_insert_id($con)

$input->root->id = mysqli_insert_id($db_handle);

print json_encode($input);