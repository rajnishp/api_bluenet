<?php
$scriptStartTime = time();
session_start();

require_once "includes/header.php";
require_once "includes/error.php";
require_once "includes/DBconnect.php";
require_once "includes/sms.php";
require_once "includes/routes.php";
require_once "includes/getOS_Brow.php";
require_once "includes/writeLog.php";


mysqli_close($db_handle);

if ((time()-$scriptStartTime) > 2){
    apiTakingMoreTime("Server took more the 2 sec for api call: \n" . json_encode($_SERVER),(time()-$scriptStartTime));
}
?>
