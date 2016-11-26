<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 4/2/16
 * Time: 6:55 PM
 */

/*
 * output {root:{score:[
 * {"user_id": 2,"name":"rahul","score":"50"},
 * {"user_id": 3,"name":"same","score":"50"}
 * ]}}
 *
 * */
$input = json_decode(file_get_contents("php://input"));
//var_dump($input);

//$user_id = $_SESSION['user_id'];

$sql = "select id,name,sum(timed)/(2160*13) as score from (SELECT u.id , u.name , timediff( t.end_time, t.start_time ) AS timed
FROM `bluenet_v3`.`users` AS u
INNER JOIN `bluenet_v3`.workers AS w
INNER JOIN `bluenet_v3`.worker_working_timings AS t
WHERE u.type != 'customer'
AND u.id = w.ref_id
AND w.id = t.worker_id
) as a where 1
group by id
ORDER BY `score`  DESC";
//echo $sql;
$result = mysqli_query($db_handle,
    $sql);

for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"scores\":";
print json_encode($costsArr);
echo "}}";

?>