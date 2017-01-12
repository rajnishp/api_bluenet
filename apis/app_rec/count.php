<?php

$input = json_decode(file_get_contents ("php://input"));

$location = "SELECT count(id) as count from cities WHERE 1 ;";
$locationData = mysqli_query ($db_handle_bt_sp, $location);
$data['location'] = mysqli_fetch_array($locationData)['count'];

$workerSp = "SELECT count(id) as count from service_providers WHERE 1 ;";
$workerDataSp = mysqli_query ($db_handle_bt_sp, $workerSp);
$worker = "SELECT count(id) as count from bluenet_v3.workers WHERE 1 ;";
$workerData = mysqli_query ($db_handle, $worker);
$data['worker'] = (mysqli_fetch_array($workerDataSp)['count'] + mysqli_fetch_array($workerData)['count']);

$user = "SELECT count(id) as count from bluenet_v3.users WHERE type = 'customer' ;";
$userData = mysqli_query ($db_handle, $user);
$data['user'] = mysqli_fetch_array($userData)['count'];

$request = "SELECT count(id) as count from bluenet_v3.service_request WHERE 1 ;";
$requestData = mysqli_query ($db_handle, $request);
$data['request'] = mysqli_fetch_array($requestData)['count'];

echo '{"root":'.json_encode($rows).'}';
?>