<?php

$sql = "SELECT u.id as id, u.name, u.mobile, w.id as worker_id , w.emergency_no
FROM `bluenet_v3`.`workers` as w inner join `bluenet_v3`.users as u
WHERE w.`ref_id` =" . $_GET['user_id'] ." and w.user_id = u.id  ";

$result = mysqli_query($db_handle, $sql);
//echo $sql;


for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"workers\":";
print json_encode($costsArr);
echo "}}";

?>
