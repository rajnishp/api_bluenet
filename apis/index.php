<?php

session_start();

require_once "includes/header.php";
require_once "includes/error.php";
require_once "includes/DBconnect.php";
require_once "includes/sms.php";
require_once "includes/routes.php";


mysqli_close($db_handle);

?>
