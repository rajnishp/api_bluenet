<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 3/12/16
 * Time: 5:43 PM
 */

require_once "includes/error.php";
require_once "includes/DBconnect.php";
require_once "includes/sms.php";


$sql = "SELECT  *
                  FROM `mobac`.`raw_json`
                  WHERE cleaned = 0; ";
//echo $sql;
$result = mysqli_query($db_handle,
    $sql);


for($contactsRawArr = array(); $cost = mysqli_fetch_assoc($result); $contactsRawArr[] = $cost);



foreach ($contactsRawArr as $key => $contact) {

    var_dump($contact);
    $contactArr = json_decode($contact["raw"]);
    var_dump($contactArr);
    /** @var TYPE_NAME $e */
    try {

        foreach ($contactArr->all->phoneNumbers as $phoneNumber) {
            $sql = "INSERT INTO `mobac`.`contacts` (`id`, `client_id`, `name`, `mobile`, `email`, `location`)
					VALUES (NULL,
						'',
						'" . $contactArr->name . "',
						'" . substr(str_replace('+', '',str_replace('-', '',preg_replace('/\s+/', '',$phoneNumber->value))), -10) . "',
						'',
						'" . $contact["location"] . "');";

            $user = mysqli_query($db_handle, $sql);
        }

        foreach ($contactArr->all->emails as $email) {
            $sql = "INSERT INTO `mobac`.`contacts` (`id`, `client_id`, `name`, `mobile`, `email`, `location`)
					VALUES (NULL,
						'',
						'" . $contactArr->name . "',
						'',
						'" . $email->value . "',
						'" . $contact["location"] . "');";

            $user = mysqli_query($db_handle, $sql);
        }
        $sql = "UPDATE `mobac`.`raw_json` SET `cleaned` = 1 WHERE `raw_json`.`id` = " . $contact["id"] . ";";
        $user = mysqli_query($db_handle, $sql);
    }catch(Exception $e){
        var_dump($e);
        die();
    }



}

mysqli_close($db_handle);

?>