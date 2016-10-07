<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 10/7/16
 * Time: 11:24 AM
 */
/*
{ 'root':
    {
        'mobile': "98989898989",
        'pv': '34234',
        'ac': 'asdfa',
        'vc':'adf';
        'dl':'safd',
        'pc': 'asfd',
        'user_id': 1212

    }
}
*/

$input = json_decode(file_get_contents("php://input"));
print_r($input);
function getUserProfile($db_handle,$userId){
    $data = "";
    $userdata = mysqli_query($db_handle, 
        "SELECT a.id AS id, a.name, a.mobile, a.rating, a.photo, a.address, 
          b.id AS worker_id, b.emergency_no, b.status, b.local_id, b.native_place, b.native_add, b.dob,
          c.pv, c.adhar_card, c.voter_id, c.driving_license, c.pan_card, 
          d.name as lord_name, d.mobile as lord_mobile, d.address as lord_address 
          FROM `bluenet_v3`.`users` AS a 
          LEFT JOIN `bluenet_v3`.`workers` AS b on b.user_id = '".$userId."'
          LEFT JOIN `bluenet_v3`.user_documents AS c ON c.user_id = '".$userId."'
          LEFT JOIN `bluenet_v3`.users AS d ON b.ref_id = d.id 
          WHERE a.id = '".$userId."'");
    $userdatarow = mysqli_fetch_assoc($userdata);
    return  $userdatarow;                                          
}

if($input->root->user_id){
    $userId =  $input->root->user_id;
}
else if($input->root->mobile){
    $sql = "SELECT `id` FROM `users` WHERE `mobile` ='".$input->root->mobile."'";
}
else {
    $searchPram = "";
    if ($input->root->pc){
        $searchPram = " `pc_uid` = '".$input->root->pc."'";
    }
    else if ($input->root->pv){
        $searchPram = " `pv_uid` = '".$input->root->pv."'";
    }
    else if ($input->root->ac){
        $searchPram = " `ac_uid` = '".$input->root->ac."'";
    }
    else if ($input->root->vc){
        $searchPram = " `vc_uid` = '".$input->root->vc."'";
    }
    else {
        $searchPram = " `dl_uid` = '".$input->root->dl."'";
    }
    $sql = "SELECT user_id as id FROM `user_documents_uid` WHERE". $searchPram;
}

$userrow = mysqli_query($db_handle, $sql);
$userrowid = mysqli_fetch_array($userrow);
$userId = $userrowid['id'];
$profile = getUserProfile($db_handle,$userId);


echo "{\"root\":{\"worker\":";
print json_encode($profile);
echo "}}";