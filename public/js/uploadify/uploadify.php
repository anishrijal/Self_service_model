<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    $img = uniqid().'.';
    $targetFile = rtrim($targetPath,'/') . '/' . $img;

    // Validate the file type
    $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    if (in_array($fileParts['extension'],$fileTypes)) {
        $res = move_uploaded_file($tempFile,$targetFile.$fileParts['extension']);
        if($res){
            echo $img.$fileParts['extension'];
        }else{
            echo 'Invalid file type.';
        }
    } else {
        echo 'Invalid file type.';
    }
}
?>