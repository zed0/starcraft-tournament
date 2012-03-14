<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $title?></title>
		<link rel="stylesheet" type="text/css" href="style.php" />
	</head>

	<body>
		<h1><a href="."><?php echo $title?></a></h1>

		<ul id="nav">
			<li><a href=".">Standings</a></li>
<?php
if (isset($login['id'])) {
?>
			<li><a href="report.php">Report result</a></li>
			<li><a href="logout.php">Logout</a></li>
<?php
} else {
?> 
			<li><a href="register.php">Register Team</a></li>
			<li><a href="login.php">Login</a></li>
<?php
}
?>
		</ul>
