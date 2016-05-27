<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 4/29/16
 * Time: 10:53 PM
 *
 * Area set.
 * type of service
 * time slot
 * 1. in between slot
 * 2. nearest time slot
 * 3. other location worker with transpotation
 */

$input = json_decode(file_get_contents("php://input"));

$sql = "SELECT  `time` , `cost`
                  FROM `bluenet_v3`.`plans`
                  WHERE service = '" . $route[2] . "'
                        AND service_type = 'monthly'; ";
//echo $sql;
$result = mysqli_query($db_handle, $sql);

for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

echo "{\"root\":{\"cost\":";
print json_encode($costsArr);
echo "}}";

?>