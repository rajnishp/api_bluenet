<?php

$sql = "SELECT *
FROM `bluenet_v3`.`workers`
WHERE `ref_id` =" . $_GET['user_id'];

$result = mysqli_query($db_handle, $sql);
//echo $sql;


for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"workers\":";
print json_encode($costsArr);
echo "}}";

?>
