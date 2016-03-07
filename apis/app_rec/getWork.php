<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/7/16
 * Time: 2:52 PM
 */

$input = json_decode(file_get_contents("php://input"));
//var_dump($input);

//$user_id = $_SESSION['user_id'];
$workerId = $route[2];

$currentTime = date('H:i:s', strtotime($_GET["current_time"]));
$currentTime15 = date('H:i:s', strtotime($_GET["current_time"]) + 900);

/*$sql = "SELECT wcm.user_worker_id, wcm.service_request_id "
    . "FROM `bluenet_v3`.worker_customer_match AS wcm "
    . "INNER JOIN `bluenet_v3`.timings AS t "
    . "WHERE wcm.user_worker_id ="
    . "AND t.start_time > '$currentTime' and t.start_time < '$currentTime15';";*/

$sql = "SELECT wcm.user_worker_id, wcm.service_request_id, t.start_time, t.end_time,u.name as customer_name,u.mobile as customer_mobile, u.address as customer_address\n"
    . "FROM `bluenet_v3`.worker_customer_match AS wcm\n"
    . "INNER JOIN `bluenet_v3`.timings AS t\n"
    . "INNER JOIN `bluenet_v3`.service_request AS sr\n"
    . "INNER JOIN `bluenet_v3`.users AS u\n"
    . "WHERE wcm.user_worker_id =$workerId \n"
    . "AND t.start_time > \'$currentTime\'\n"
    . "AND t.start_time < \'$currentTime15\'\n"
    . "AND t.service_request_id = sr.id\n"
    . "AND sr.user_id = u.id";

//echo $sql;

$work = mysqli_query($db_handle, $sql);

//var_dump(mysqli_fetch_assoc($work));

if (mysqli_connect_errno()) {
    /* send 500 html header*/
    internalServerError("Error description: " . mysqli_error($db_handle));
    echo("Error description: " . mysqli_error($db_handle));
    die();
}

echo "{\"root\":{\"work\":";
print json_encode(mysqli_fetch_assoc($work));
echo "}}";