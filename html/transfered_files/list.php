<?php
session_start();

// Check if the user is authenticated
if(empty($_SESSION['userid']) || $_SESSION['userid']=='') {
    header('Location: /iisstart.php?naughtynaughty'); // Redirect unauthenticated users to a login page
    exit();
}

if (isset($_GET['error'])) {
	if ($_GET['error'] == "No.") {
		echo "<script type='text/javascript'>alert('You stop that.');</script>";
	}
}

// Define the directory path
$directory = '/var/www/html/transfered_files/'; // Replace with the actual path to your directory

// Open the directory
if ($handle = opendir($directory)) {
    echo "<h1>File List</h1>";
    
    // Loop through the files
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && $entry != "list.php") {	//Checked for LFI with LFI-Jhaddix.txt wordlist; nothing found.
            echo "<a href='/download.php?file=" . urlencode($entry) . "'>$entry</a><br>";
        }
    }
    closedir($handle);
} else {
    echo "Could not open directory.";
}
?>

<html>
	<head>
		<a href="/mainpage.php">Upload a file.</a>
	</head>
</html>
