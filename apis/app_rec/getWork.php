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
$currentTime15 = date('H:i:s', strtotime("+15 minutes", $_GET["current_time"]));

$sql = "SELECT *\n"
    . "FROM worker_customer_match AS wcm\n"
    . "INNER JOIN timings AS t\n"
    . "WHERE wcm.user_worker_id =$workerId\n"
    . "AND t.start_time > \'$currentTime\' and t.start_time < \'$currentTime15\'";

$work = mysqli_query($db_handle, $sql);


echo "{\"root\":";
print json_encode(mysqli_fetch_assoc($work));
echo "}";