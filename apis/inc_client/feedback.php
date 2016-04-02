<?php
/**
 * Created by PhpStorm.
 * User: rahul
 * Date: 28/2/16
 * Time: 2:03 PM
 *
 * CREATE TABLE `feedbacks` (
 * `id` int(16) NOT NULL AUTO_INCREMENT,
 * `feedback` varchar(500) NOT NULL,
 * `mobile` varchar(16) NOT NULL,
 * `email` varchar(50) NOT NULL,
 * `name` varchar(20) NOT NULL,
 * `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 * `location` varchar(80) NOT NULL,
 * `type` enum('teastamonials','complain') NOT NULL,
 * PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8
 */

$input = json_decode(file_get_contents("php://input"));
//var_dump($input);


$sql = "INSERT INTO `feedbacks` (`id`, `feedback`,  `mobile`, `email`, `name`, `location`)
					VALUES (NULL,
						'" . $input->root->feedback . "',
						'" . $input->root->mobile . "',
						'" . $input->root->email . "',
						'" . $input->root->name . "',
						'" . $input->root->gps_location . "');";

$user = mysqli_query($db_handle, $sql);
$emailIds = array("rahul_lahoria@yahoo.com", "pwnpnwr785@gmail.com", "vikas.niper2012@gmail.com", "kumar.anil8892@yahoo.com");
foreach ($emailIds as $to)
    sendMail($to, "mobile app feedback", json_encode($input));


?>