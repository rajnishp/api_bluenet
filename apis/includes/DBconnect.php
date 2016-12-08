<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/9/16
 * Time: 11:00 PM
 */

$config['host'] = "localhost";
$config['user'] = "root";
$config['password'] = "redhat@11111p";
$config['database'] = "bluenethack_v0";

$db_handle = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);

if (mysqli_connect_errno()) {
    /* send 500 html header*/
    internalServerError("Error description: " . mysqli_error($db_handle));
    echo("Error description: " . mysqli_error($db_handle));
    die();

}


?>