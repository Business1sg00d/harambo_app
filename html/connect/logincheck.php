<?php
if (isset($_POST["login"])) {
    $userlogin = $_POST["userlogin"];
    $passwordlogin = $_POST["passwordlogin"];
   
    require_once 'dbh.connect.php';
    require_once 'functions.connect.php';
    
    if (emptyInputLogin($userlogin, $passwordlogin) !== false) {
        header("location: /iisstart.php?error=emptyinput");
        exit();
    }

    loginuser($conn, $userlogin, $passwordlogin);
}else{
    header("location: /iisstart.php");
}          
