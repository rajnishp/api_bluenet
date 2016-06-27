<?php

if(isset($_GET['user_id'])) {
    $sql = "SELECT u.id AS id, u.name, u.mobile, u.rating, w.id AS worker_id, w.emergency_no, ud.adhar_card, ud.voter_id, ud.driving_license, ud.pan_card
FROM `bluenet_v3`.`workers` AS w
LEFT JOIN `bluenet_v3`.users AS u ON w.user_id = u.id
LEFT JOIN `bluenet_v3`.user_documents AS ud ON u.id = ud.user_id
WHERE w.`ref_id` =". $_GET['user_id'];
}

if(isset($route[2]))
    $sql = "SELECT  `name` , `mobile` , `email`  , `address` , `area` ," .
        " `rating`, `photo`   FROM `bluenet_v3`.`users`  WHERE md5_id = '" . $route[2] . "'; ";

$result = mysqli_query($db_handle, $sql);
//echo $sql;


for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"workers\":";
print json_encode($costsArr);
echo "}}";

?>
