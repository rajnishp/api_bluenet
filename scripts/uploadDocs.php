<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 8/14/16
 * Time: 8:47 PM
 */


function UploadDocs($dataDir, $localId){

    $outArray = array('photo' => 0,'pv'=>0,'adhar_card'=> 0,'voter_card' => 0, 'driving_license' => 0, 'pan_card' => 0);

    //$files1 = scandir($dataDir);

    if (file_exists($dataDir.$localId."/".$localId.".jpg")) {
        $outArray['photo'] = upload_file($dataDir.$localId."/".$localId.".jpg");
    }

    if (file_exists($dataDir.$localId."/aadhar.pdf")) {
        $outArray['adhar_card'] = upload_file($dataDir.$localId."/aadhar.pdf");
    }

    if (file_exists($dataDir.$localId."/pv.pdf")) {
        $outArray['pv'] = upload_file($dataDir.$localId."/pv.pdf");
    }

    if (file_exists($dataDir.$localId."/votor_card.pdf")) {
        $outArray['voter_card'] = upload_file($dataDir.$localId."/votor_card.pdf");
    }

    if (file_exists($dataDir.$localId."/driving_license.pdf")) {
        $outArray['driving_license'] = upload_file($dataDir.$localId."/driving_license.pdf");
    }

    if (file_exists($dataDir.$localId."/pan.pdf")) {
        $outArray['pan_card'] = upload_file($dataDir.$localId."/pan.pdf");
    }



    return $outArray;

}