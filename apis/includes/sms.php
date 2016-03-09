<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/9/16
 * Time: 11:01 PM
 */

function sendSMS($to, $message){
    $username = "rajnish90";
    $password = "redhat12345";
    $senderid = "BLUETM";

    return httpGet("http://www.smsjust.com/blank/sms/user/urlsms.php?".
        "username=".$username.
        "&pass=".$password.
        "&senderid=".$senderid.
        "&message=".$message.
        "&dest_mobileno=".$to.
        "&msgtype=TXT");
}

function httpGet($url){
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false);

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}
?>