<?php
    include("/var/www/config.php");

    $conn =  new mysqli($localhost, $mysqluser, $mysqlpass, $database);
                    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
