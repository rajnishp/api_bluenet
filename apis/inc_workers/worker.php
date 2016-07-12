<?php

/*
 * this api are not secure make them secure.....
 * All are write JIT (Just In Time)
 * */

if(isset($_GET['user_id'])) {
    $sql = "SELECT u.id AS id, u.name, u.mobile, u.rating, u.photo, u.`address` , u.`area` , w.id AS worker_id, w.emergency_no,".
        " ud.adhar_card, ud.voter_id, ud.driving_license, ud.pan_card, w.`status`,w.`native_place`,w.`dob` ".
        " FROM `bluenet_v3`.`workers` AS w".
        " LEFT JOIN `bluenet_v3`.users AS u ON w.user_id = u.id
LEFT JOIN `bluenet_v3`.user_documents AS ud ON u.id = ud.user_id
WHERE w.`ref_id` =". $_GET['user_id'];
}

if(isset($route[2]) && $route[2] == "society" && isset($_GET['society_id']) ){

    $sql = "SELECT u.id AS id, u.name, u.mobile, u.rating, u.photo, u.`address` , u.`area` , w.id AS worker_id, w.emergency_no,".
        " ud.adhar_card, ud.voter_id, ud.driving_license, ud.pan_card, w.`status`,w.`native_place`,w.`dob` ".
        " FROM `bluenet_v3`.`society_worker_mapping` AS swm ".
        " LEFT JOIN `bluenet_v3`.`workers` AS w on swm.worker_id = w.id".
        " LEFT JOIN `bluenet_v3`.users AS u ON w.user_id = u.id
LEFT JOIN `bluenet_v3`.user_documents AS ud ON u.id = ud.user_id
WHERE swm.`society_id` =". $_GET['society_id'];

}

elseif(isset($route[2]))
    $sql = "SELECT  u.`name` , u.`mobile` , u.`email`  , u.`address` , u.`area` , " .
        " u.`rating`, u.`photo`, w.`status`, w.`emergency_no`,w.`native_place`,w.`dob` ".
        "FROM `bluenet_v3`.`users` as u left join `bluenet_v3`.`workers` AS w ON w.user_id = u.id WHERE md5_id = '" . $route[2] . "'; ";

$result = mysqli_query($db_handle, $sql);
//echo $sql;


for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"workers\":";
print json_encode($costsArr);
echo "}}";

?>
