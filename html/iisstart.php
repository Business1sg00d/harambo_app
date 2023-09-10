<html>
<head>
<h1>He's back...and he's pissed.</h1>
</head>
<body>
<style type="text/css">
h1{
	font-size: 50;
}

body {
	color: green;
	background: url("monke.jpg");
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center;
	margin:0;
	text-align:center;
}

.loginbox {
	position: relative;
	z-index: 1;
	max-width: 360px;
	margin: 0 auto 100px;
	padding: 45px;
	text-align: center;
	box-shadow 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

</style>
<title>Login Form Design</title>
<div class="loginbox">
<h1>Login Here</h1>
<form action="/connect/logincheck.php" method="post">
	<p>Username</p>
	<input type="text" name="userlogin" id="user" placeholder="Enter Username">	
	<p>Password</p>
	<input type="password" name="passwordlogin" id="pass" placeholder="Enter Password">		
	<input type="submit" name="login" value="Login">
</form>

<?php
if (isset($_GET["error"])) {
	if ($_GET["error"] == "emptyinput") {
		$emptyinput="Fill out the form....";
		echo "<script type='text/javascript'>alert('$emptyinput');</script>";
	}else if ($_GET["error"] == 'incorrectlogin') {
		$wronglogin="Login information is incorrect.";
		echo "<script type='text/javascript'>alert('$wronglogin');</script>";
	}
}
?>
</body>
</html>
