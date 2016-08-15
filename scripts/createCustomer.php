<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 8/14/16
 * Time: 8:46 PM
 */

function createCustomer($db_handle,$name,$mobile,$address){


    $sql = "INSERT INTO `users` ( `id` , `name` , `mobile` , `email` , `password` , `type` , `address` , `area` ," .
        " `creation` ,  `society_id`  )
			VALUES (NULL ,
			'" . $name . "',
			'" . $mobile . "',
			'',
			'" . $mobile . "',
			'customer',
			'".$address."',
			'',
			'" . date("Y-m-d H:i:s") . "',
			'2'

			);";

    mysqli_query($db_handle, $sql);


    $id = mysqli_insert_id($db_handle);

    mysqli_query($db_handle, "Update users set md5_id = MD5(".$id .") where id = ".$id );

    return $id;
}