<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 4/19/16
 * Time: 4:42 PM
 */

$input = json_decode(file_get_contents ("php://input"));
$header = json_encode($_SERVER);
$url = $_SERVER[REQUEST_URI];


$sql = "INSERT INTO `request_logs`.`raw_logs` (id, input, header, url)
				VALUES (NULL,
					'".	json_encode($input)."',
					'". $header."',
					'". $url."'
					);";

$user = mysqli_query ($db_handle, $sql);
