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

$sql = "SELECT  `time` , `cost`
                  FROM `bluenet_v3`.`plans`
                  WHERE service = '" . $route[2] . "'
                        AND service_type = 'monthly'; ";
//echo $sql;
$result = mysqli_query($db_handle,
    $sql);

for($costsArr = array(); $cost = mysqli_fetch_assoc($result); $costsArr[] = $cost);

//$scope.prices = d['root'].cost;

$days =intval($input->root->days);

$noOfMaxDays = ($days>26 || $days<21)?26:($days);

$max = $noOfMaxDays*intval($costsArr[0]["cost"]);

$startHour = date('H', strtotime($input->root->selectedTime));

for($i = 1;$i < $input->root->hours;$i++) {
    $max = $max + ($noOfMaxDays * intval($costsArr[($startHour + $i)%24]["cost"]));

}

                    $min = 21*intval($costsArr[0]["cost"]);

for($i = 1;$i < $input->root->hours;$i++) {
    $min = $min + (21 * intval($costsArr[($startHour + $i)%24]["cost"]));

}

                    $days = ($days<15)?15:$days;
                    $forDays = $days*intval($costsArr[0]["cost"]);
for($i = 1;$i < $input->root->hours;$i++) {
    $forDays = $forDays + ($days * intval($costsArr[($startHour + $i)%24]["cost"]));

}

                    $discount = ($forDays>$max)?$forDays:false ;
                    $forDays = ($forDays>$max)?$max:$forDays;
                    $avg = ($max + $min)/2;

$input->root->max = $max;
$input->root->min = $min;
$input->root->avg = $avg;
$input->root->discount = $discount;
$input->root->days = $days;
$input->root->forDays = $forDays;

print json_encode($input);

?>