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

$sql = "SELECT sr.id, service,service_type,salary,start_time,end_time, "
    ." u.id as cem_id, u.name as cem_name, u.mobile as cem_mobile, r.rating as cem_rating,  "
    ." uw.id as worker_id, uw.name as worker_name, uw.mobile as worker_mobile, wr.rating as worker_rating  "
    . "FROM `bluenet_v3`.`service_request` AS sr "
    . "LEFT JOIN `bluenet_v3`.worker_customer_match AS wcm ON sr.id = wcm.service_request_id AND wcm.type != 'leave' "
    . "LEFT JOIN `bluenet_v3`.users AS uw ON wcm.user_worker_id = uw.id  "
    . "LEFT JOIN `bluenet_v3`.timings AS t  ON sr.id = t.service_request_id "

    . "LEFT JOIN `bluenet_v3`.ratings AS r ON sr.user_cem_id = r.user_id AND sr.user_id = r.customer_user_id  "
    . "LEFT JOIN `bluenet_v3`.ratings AS wr ON wcm.user_worker_id = wr.user_id AND sr.user_id = wr.customer_user_id "
    . "LEFT JOIN `bluenet_v3`.users AS u ON sr.user_cem_id = u.id "

    . "WHERE sr.mobile = '" . $route[2]  ."' ";

$result = mysqli_query($db_handle, $sql);
//echo $sql;


for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"srs\":";
print json_encode($costsArr);
echo "}}";

?>