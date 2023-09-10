<?php
session_start();

// Check if the user is authenticated
if(empty($_SESSION['userid']) || $_SESSION['userid']=='') {
    header('Location: /iisstart.php?naughtynaughty'); // Redirect unauthenticated users to a login page
    exit();
}

$fileName = $_GET['file'];

//No reason to access list.php.
if (preg_match('/^.*list.php$/', $fileName)) {
	header('Location: /transfered_files/list.php?error=pissoff');
	exit();
}

// Define the directory path
$directory = '/var/www/html/transfered_files/'; // Replace with the actual path to your directory

// Ensure the file exists and is within the specified directory
if (file_exists($directory . $fileName) && strpos(realpath($directory . $fileName), realpath($directory)) === 0) { //Helps prevent LFI.
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($fileName));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($directory . $fileName));
    readfile($directory . $fileName);
    exit;
} else {
    echo "File not found.";
}
?>

