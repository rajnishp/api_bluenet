<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 8/15/16
 * Time: 3:12 PM
 */

function validateDirStr($dir){

    $files1 = scandir($dir);
    $files = array("aadhar.pdf","pv.pdf","votor_card.pdf","driving_license.pdf","pan.pdf");

    for($i=2;$i <= count($files1);$i++){

        $in = scandir($dir.$files1."/");

        for($j=2;$j <= count($in);$j++){

            if(in_array($in[$j],$files)){

            }
            else {
                echo "I can not accept \n";
                echo $dir.$files1."/".$in[$j] ;
                return false;
            }


        }
    }

    return true;

}