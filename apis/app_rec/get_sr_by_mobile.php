<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/6/16
 * Time: 9:00 PM
 */

$input = json_decode(file_get_contents("php://input"));
//var_dump($input);

//$user_id = $_SESSION['user_id'];

$result = mysqli_query($db_handle, "SELECT  *  FROM `bluenet_v3`.`service_request` as sr"
    . "INNER JOIN `bluenet_v3`.timings AS t "
    ." WHERE sr.mobile = '" . $route[2]
    . "AND sr.id = t.service_request_id "
    . "'; ");

$details = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) >= 1)
    $details['user_exist'] = true;
else
    $details['user_exist'] = false;


echo "{\"root\":{\"user\":";
print json_encode($details);
echo "}}";

?>