<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 9/3/16
 * Time: 1:38 PM
 */

$input = json_decode(file_get_contents("php://input"));

function createCustomer($db_handle,$name,$mobile,$address,$society){


    $sql = "INSERT INTO `bluenet_v3`.`users` ( `id` , `name` , `mobile` , `email` , `password` , `type` , `address` , `area` ," .
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
			'".$society."'

			) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);";

    mysqli_query($db_handle, $sql);


    $id = mysqli_insert_id($db_handle);

    if($id == 0){
        echo " Error: " . mysqli_error($db_handle);
    }
    mysqli_query($db_handle, "Update users set md5_id = MD5(".$id .") where id = ".$id );

    return $id;
}
function createCustomerWorker($db_handle,$name,$mobile,$address,$photo,$refId,$localId,
                              $service,
                              $pv,$adhar_card,$voter_card,$driving_license,$pan_card,
                              $emergency_no, $native_add, $society){


    //1. adding user worker
    $sql = "INSERT INTO `bluenet_v3`.`users` ( `id` , `name` , `mobile` , `email` , `password` , `type` , `address` , `area` ," .
        " `creation` , society_id, photo )
			VALUES (NULL ,
			'" . $name . "',
			'" . $mobile . "',
			'',
			'" . $mobile . "',
			'worker',
			'".$address."',
			'',
			'" . date("Y-m-d H:i:s") . "',
			'".$society."',
            '".$photo."'
			) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id) ;";

    mysqli_query($db_handle, $sql);

    $uwId = mysqli_insert_id($db_handle);

    //echo $uwId. "\n";
    if($uwId == 0 || $uwId == null){
        echo " Error: " . mysqli_error($db_handle);die();
    }


    //2. updating md5 id
    $result = mysqli_query($db_handle, "Update `bluenet_v3`.users set md5_id = MD5(".$uwId .") where id = ".$uwId );

    //3. adding worker docs
    $sql = "INSERT INTO `bluenet_v3`.`user_documents` (`id`,  `user_id`, `pv`, `adhar_card`, `voter_id`, `driving_license`, `pan_card`)
				VALUES (NULL,
					'" . $uwId . "',
					'" . $pv . "',
					 '" . $adhar_card . "',
					  '" . $voter_card . "',
					   '" . $driving_license . "',
						'" . $pan_card . "');";

    $result = mysqli_query($db_handle, $sql);


    //4. adding worker
    /*INSERT INTO `bluenet_v3`.`workers` (`id`, `ref_id`, `user_id`, `status`, `emergency_no`, `native_place`, `native_add`, `dob`, `education`, `experience`, `gender`, `remark`, `salary`, `bonus`) VALUES
    (NULL, '1', '3', 'new', '9090909090', 'delhi', 'asdf', '2016-04-05', '10', '5', 'M', 'afsdv', '1000', '2');*/
    $sql = "INSERT INTO `bluenet_v3`.`workers` (`id`, `ref_id`, `user_id`, `status`, `emergency_no`, `native_place`,
								`native_add`, `dob`, `education`, `experience`, `gender`, `remark`, `salary`, `local_id`)
				VALUES (NULL,
					'" . $refId . "',
					'" . $uwId . "',
					 'recruited',
					 '" . $emergency_no . "',
					  '',
					   '" . $native_add . "',
						'',
						 '',
						 '',
						  '',
						   '',
							'',
							 '".$localId."');";

    mysqli_query($db_handle, $sql);

    $wId = mysqli_insert_id($db_handle);
    //echo $wId. "\n";
    if($wId == 0 ||$wId == null){
        echo " Error: " . mysqli_error($db_handle);die();
    }

    $sId = array('maid'=> 1,'cook' => 2, 'car cleaner' => 15 );

    //5. adding worker service
    $sql = "INSERT INTO `bluenet_v3`.`service_worker_mappings`
				(`id`, `worker_id`, `service_id`)
					VALUES ('',
					'" . $wId . "',
					 '" . $sId[$service] . "'
					 );";

    mysqli_query($db_handle, $sql);

    //6. adding worker society mapping
    $sql = "INSERT INTO `bluenet_v3`.`society_worker_mapping`
				(`worker_id`, `society_id`)
					VALUES (
					'" . $wId . "',
					 '".$society."'
					 );";

    mysqli_query($db_handle, $sql);

    return $uwId;
}

function createDocUid($dbHandle,$uwId,$pvUid,$adharCardUid, $voterCardUid, $drivingLicenseUid, $panCardUid){

    $sql = "INSERT INTO `bluenet_v3`.`user_documents_uid` (`id`,  `user_id`, `pv_uid`, `adhar_card_uid`, `voter_id_uid`, `driving_license_uid`, `pan_card_uid`)
				VALUES (NULL,
					'" . $uwId . "',
					'" . $pvUid . "',
					 '" . $adharCardUid . "',
					  '" . $voterCardUid . "',
					   '" . $drivingLicenseUid . "',
						'" . $panCardUid . "');";

    return mysqli_query($dbHandle, $sql);

}





$refId = createCustomer($db_handle,$input->root->resident_name,$input->root->resident_mobile,$input->root->resident_address, $route[2]);


if($refId != 0) {
    $wId = createCustomerWorker($db_handle, $input->root->worker_name, $input->root->worker_mobile, $input->root->worker_address,
        $input->root->worker_photo, $refId, $input->root->worker_localId,
        $input->root->worker_service,
        $input->root->worker_pv, $input->root->worker_ac, $input->root->worker_vc, $input->root->worker_dl, $input->root->worker_pc,
        $input->root->worker_emergency_no, $input->root->worker_native_add, $route[2]);

    createDocUid($db_handle,$wId,$input->root->worker_pv_uid,$input->root->worker_ac_uid,
        $input->root->worker_vc_uid, $input->root->worker_dl_uid, $input->root->worker_pc_uid);
//echo $refId." ".$wId.",";

    $input->root->resident_id = $refId;
    $input->root->worker_id = $wId;
}
print json_encode($input);