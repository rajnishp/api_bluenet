<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/6/16
 * Time: 9:00 PM
 */

$input = json_decode(file_get_contents("php://input"));
//var_dump($input);

//$user_id = $_SESSION['user_id'];

$result = mysqli_query($db_handle, "SELECT  `id`,`name` , `mobile` , `email` , `type` , `address` , `area` ," .
    " `creation` ,  `gps_location` , `device_id`  FROM `bluenet_v3`.`users` WHERE mobile = '" . $input->root->mobile . "'
      AND password = '" . $input->root->password . "'; ");

$details = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) >= 1) {
    $details['user_exist'] = true;
    if ($route[2] == "society"){
        echo $details['society_id'];

        $result = mysqli_query($db_handle, "SELECT  * FROM societies WHERE id = ".$details['society_id']." ; ");
        $societyD = mysqli_fetch_assoc($result);
        $who = "";

        if($societyD['president_user_id'] == $details['id'] ) $who = "president";
        if($societyD['cashier_user_id'] == $details['id'] ) $who = "cashier";
        if($societyD['secretary_user_id'] == $details['id'] ) $who = "secretary";
        if($societyD['staff_user_id'] == $details['id'] ) $who = "staff";

        if($who != ""){
            $details['who'] = $who;
            $details['society'] = $societyD;
        }



    }
}
else
    $details['user_exist'] = false;


echo "{\"root\":{\"user\":";
print json_encode($details);
echo "}}";

?>