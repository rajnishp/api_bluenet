<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/12/16
 * Time: 12:13 AM
 */

$input = json_decode(file_get_contents("php://input"));
//var_dump($input);

//$user_id = $_SESSION['user_id'];

$result = mysqli_query($db_handle,
            "SELECT  `time` , `cost` ,
                  FROM `bluenet_v3`.`plans`
                  WHERE service = '" . $route[2] . "',
                        service_type = 'monthly'; ");

$details = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) >= 1)
    $details['user_exist'] = true;
else
    $details['user_exist'] = false;


echo "{\"root\":{\"cost\":";
print json_encode($details);
echo "}}";

?>