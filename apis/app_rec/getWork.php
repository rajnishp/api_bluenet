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

$sql = "SELECT * "
    . "FROM worker_customer_match AS wcm "
    . "INNER JOIN timings AS t "
    . "WHERE wcm.user_worker_id =$workerId "
    . "AND t.start_time > '$currentTime' and t.start_time < '$currentTime15'";

echo $sql;

$work = mysqli_query($db_handle, $sql);

var_dump($work);

if (mysqli_connect_errno()) {
    /* send 500 html header*/
    internalServerError("Error description: " . mysqli_error($db_handle));
    echo("Error description: " . mysqli_error($db_handle));
    die();
}

echo "{\"root\":\"{work:\"";
print json_encode(mysqli_fetch_assoc($work));
echo "}}";