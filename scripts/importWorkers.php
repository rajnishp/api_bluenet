<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 8/14/16
 * Time: 10:25 PM
 */


require_once 'createCustomer.php';
require_once 'createCustomerWorker.php';
require_once 'fileUpload.php';
require_once 'uploadDocs.php';
require_once 'validateDirStr.php';

function phoneNumbervalidation($mobile){
    if (preg_match('/^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1})?([0-9]{10})$/', $mobile, $matches)) {
        print_r($matches);
        return true;
    } else
        return false;
}

$DataCSVFile = "Sheet9.csv";
$dataDir = "/home/ubuntu/data/doc/";

if (!validateDirStr($dataDir)){
    die("\n invalid File Structure\n");
}

$config['host'] = "localhost";
$config['user'] = "root";
$config['password'] = "redhat@11111p";
$config['database'] = "bluenet_v3";


$db_handle = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);




if (($handle = fopen( $DataCSVFile, "r")) !== FALSE) {

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        $lName = $data[8];
        $lMobile = $data[9];
        $lAddress = $data[4];
        $localId = $data[0];
        $wName = $data[1];
        $wMobile = $data[2];
        $wAddress = $data[7];
        $service = $data[6];
        $emergency_no = $data[3];
        $native_add = $data[5];

        $refId = createCustomer($db_handle,$lName,$lMobile,$lAddress);
        $outArray = UploadDocs($dataDir, $localId);

        $wId = createCustomerWorker($db_handle,$wName,$wMobile,$wAddress,$outArray['photo'],$refId,$localId,
            $service,
            $outArray['pv'], $outArray['adhar_card'],$outArray['voter_card'],$outArray['driving_license'],$outArray['pan_card'],
            $emergency_no, $native_add);

        echo $wId.",";


    }
    fclose($handle);
}


mysqli_close($db_handle);
