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
var_dump($input);


$sql = "INSERT INTO `feedbacks` (`id`, `feedback`,  `mobile`, `email`, `name`, `location`)
					VALUES (NULL,
						'" . $input->root->feedback . "',
						'" . $input->root->mobile . "',
						'" . $input->root->email . "',
						'" . $input->root->name . "',
						'" . $input->root->gps_location . "');";

$user = mysqli_query($db_handle, $sql);
if (mysqli_connect_errno()) {
    /* send 500 html header*/
    internalServerError("Error description: " . mysqli_error($db_handle));
    echo("Error description: " . mysqli_error($db_handle));
    die();
}


?>