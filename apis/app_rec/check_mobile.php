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

$result = mysqli_query($db_handle, "SELECT * FROM `bluenet_v3`.`users` WHERE mobile = '" . $route[2] . "'; ");


echo "{\"root\":";
if (mysqli_num_rows($result) >= 1)
    echo "{'user_exist': true}";
else
    echo "{'user_exist': false}";
echo "}";

?>