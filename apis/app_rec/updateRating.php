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