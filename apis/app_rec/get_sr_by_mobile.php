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

/*$sql = "SELECT  *  FROM `bluenet_v3`.`service_request` as sr"
. "INNER JOIN `bluenet_v3`.timings AS t "
." WHERE sr.mobile = '" . $route[2]  ."'"
. "AND sr.id = t.service_request_id "
. "; ";*/

$sql = "SELECT sr.id, mobile,service,service_type,salary,user_cem_id,start_time,end_time, u.id as cem_id, u.name as cem_name, u.mobile as cem_mobile  "
    . "FROM `bluenet_v3`.`service_request` AS sr "
    . "INNER JOIN `bluenet_v3`.timings AS t "
    . "INNER JOIN `bluenet_v3`.users AS u "
    . "WHERE sr.mobile = '" . $route[2]  ."' "
    . "AND sr.id = t.service_request_id"
    . "AND sr.user_cem_id = u.id";

$result = mysqli_query($db_handle, $sql);
//echo $sql;


for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"srs\":";
print json_encode($costsArr);
echo "}}";

?>