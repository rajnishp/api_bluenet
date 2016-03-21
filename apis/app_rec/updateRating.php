<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/14/16
 * Time: 11:09 AM
 */
$input = json_decode(file_get_contents("php://input"));

//

$sql = "INSERT INTO `bluenet_v3`.`ratings` (`id`, `user_id`, `customer_user_id`, `rating`) VALUES
            (NULL,
             '" . $input->root->user_id . "',
             '" . $input->root->customer_id . "',
             '" . $input->root->rating . "') ON DUPLICATE KEY UPDATE rating = '" . $input->root->rating . "' ;";

$result = mysqli_query($db_handle, $sql);

$input->root->id = mysqli_insert_id($db_handle);

print json_encode($input);