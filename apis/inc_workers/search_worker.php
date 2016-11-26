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

function getUserProfile($db_handle,$userId){

}

if($input->root->user_id){
    $userId =  $input->root->user_id;
}
else if($input->root->mobile){

}
else {
    $searchPram = "";
    if ($input->root->pc){
        $searchPram = " `pc_uid` = '".$input->root->pc."'";
    }
        $sql = "SELECT *
        FROM `user_documents_uid`
        WHERE". $searchPram;
}

$userId = mysqli_query($db_handle, $sql);

$profile = getUserProfile($db_handle,$userId);


echo "{\"root\":{\"worker\":";
print json_encode($profile);
echo "}}";