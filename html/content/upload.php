<?php
    session_start();
    if(empty($_SESSION['userid']) || $_SESSION['userid']=='') {
        header("location: /iisstart.php");
        die();
    }

if (isset($_POST['submit'])) {
    $fileName = $_FILES['uploadedfile']["name"];
    $filetmp = $_FILES['uploadedfile']["tmp_name"];
    $fileSize = $_FILES['uploadedfile']["size"];
    $fileError = $_FILES['uploadedfile']["error"];
    $target_dest = "/var/www/html/transfered_files/";
    $fileDestination = $target_dest . $fileName;
    
    if ($fileSize < 25000000) {
        move_uploaded_file($filetmp, $fileDestination);
        header("Location: /transfered_files/list.php");
    } else {
        echo "Too big.";
    }
}
?>
