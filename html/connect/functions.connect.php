<?php

function emptyInputLogin($userlogin, $passwordlogin) {
    $result;
    if (empty($userlogin) || empty($passwordlogin)) {
        $result = true;
    }else {
        $result = false;
    }
    return $result;
}

function uidExistslogin($conn, $userlogin) {
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
        header("location: iisstart.php?error=statementfailed");
    }
    else{
        $searchInput = $_POST["userlogin"]; 
        //$query="select * from member where user like '%$searchInput%'";//May be vulnerable to SQL injection; couldnt insert users
        $stmt = $conn->prepare("select * from member where user=?;");
        $stmt->bind_param("s", $searchInput);
        $stmt->execute();
        $result=$stmt->get_result();
        if ($row=$result->fetch_assoc()) {
            return $row;
        } else {
            $result = false;
            return $result;
        }
    }
}

function loginuser($conn, $userlogin, $passwordlogin) {
    $uidExistslogin = uidExistslogin($conn, $userlogin);

    if ($uidExistslogin === false) {
        header("location: /iisstart.php?error=incorrectlogin");
    }

    $pwdHashed = $uidExistslogin["pwd"];
    $checkPwd = password_verify($passwordlogin, $pwdHashed);

    if ($checkPwd === false) {
        header("location: /iisstart.php?error=incorrectlogin");
    }else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExistslogin["userid"];
        header("location: /mainpage.php");
        exit();
    }
}
