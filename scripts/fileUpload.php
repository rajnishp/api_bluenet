<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 8/14/16
 * Time: 8:08 PM
 */

// initialise the curl request
function upload_file($uri)
{
    $target_url = 'http://api.file-dog.shatkonlabs.com/files/rahul';
//This needs to be the full path to the file you want to send.
    $file_name_with_full_path = realpath('/home/spider-ninja/acc.txt');

    $cfile = curl_file_create($uri, 'image/jpeg', end(explode('/', $uri)));
    /* curl will accept an array here too.
     * Many examples I found showed a url-encoded string instead.
     * Take note that the 'key' in the array will be the key that shows up in the
     * $_FILES array of the accept script. and the at sign '@' is required before the
     * file name.
     */
    $post = array('fileToUpload' => '123456', 'fileToUpload' => $cfile);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $target_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result  = curl_exec($ch);
    curl_close($ch);
    $fileIdObj = json_decode($result);
    $fileId = $fileIdObj->file->id;
    return $fileId;

}