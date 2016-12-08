<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 8/10/16
 * Time: 5:15 PM
 */


$input = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO `bluenet_v3`.`meetings` (`id`, `user_id`, `cem_user_id`, `date_time`) VALUES
            (NULL,
             '" . $input->root->user_id . "',
             '" . $input->root->cem_id . "',
             '" . date('Y-m-d H:i:s', strtotime($input->root->date_time))  . "')  ;";

$result = mysqli_query($db_handle, $sql);

$input->root->id = mysqli_insert_id($db_handle);

print json_encode($input);

$emailIds = array("rahul_lahoria@yahoo.com", "mamtasauda91@gmail.com","pwnpnwr785@gmail.com", "vikas.niper2012@gmail.com", "kumar.anil8892@yahoo.com", "neelamdubey1988@gmail.com");
foreach ($emailIds as $to)
    sendMail($to, "meeting got scheduled", json_encode($input));