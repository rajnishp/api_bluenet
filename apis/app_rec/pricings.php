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

$sql = "SELECT  `time` , `cost` ,
                  FROM `bluenet_v3`.`plans`
                  WHERE service = '" . $route[2] . "'
                        AND service_type = 'monthly'; ";
echo $sql;
$result = mysqli_query($db_handle,
            $sql);


for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);



echo "{\"root\":{\"cost\":";
print json_encode($costsArr);
echo "}}";

?>