<?php

include 'common.php';

include 'header.php';

$error = false;
$errors = array();
if (isset($_POST['submit'])) {
	if (isset($_POST['login']) && strlen(trim($_POST['login'])) > 2) {
		$login = $_POST['login'];
	} else {
		$error = true;
		array_push($errors, "Enter a login of at least 3 characters");
	}

	if (isset($_POST['password']) && strlen(trim($_POST['password'])) > 2) {
		$password = $_POST['password'];
	} else {
		$error = true;
		array_push($errors, "Enter a password of at least 3 characters");
	}

	if (isset($_POST['name']) && strlen(trim($_POST['name'])) > 2) {
		$name = $_POST['name'];
	} else {
		$error = true;
		array_push($errors, "Enter a name of at least 3 characters");
	}

	if (isset($_POST['email']) && strlen(trim($_POST['email'])) > 2) {
		$email = $_POST['email'];
	} else {
		$error = true;
		array_push($errors, "Enter an email of at least 3 characters");
	}

	if (isset($_POST['irc']) && strlen(trim($_POST['irc'])) > 2) {
		$irc = $_POST['irc'];
	} else {
		$error = true;
		array_push($errors, "Enter an IRC nick of at least 3 characters");
	}

	if (!$error) {
		$salt = substr(md5(mt_rand()),0,10);
		$password = $salt.sha1($password.$salt);
		if ($result = $mysqli->query("INSERT INTO " . $mysql_prefix . "player(login, password, name, ircnick, email) VALUES ('".$mysqli->real_escape_string($login)."','".$password."',
'".$mysqli->real_escape_string($name)."',
'".$mysqli->real_escape_string($irc)."',
'".$mysqli->real_escape_string($email)."')")) {

?>
		<h2>Register Team</h2>
		<p>Congratulations, you are now registered, <a href="login.php">click here</a> to continue to login</p>
<?php

		} else {
			printf("Error: %s\n", $mysqli->error);
		}
	}
}

if (!isset($_POST['submit']) || $error) {

?>
		<h2>Register</h2>
<?php

	if ($error) {
		echo '<p class="error">Please correct the following errors:</p><ul class="error"><li>'.implode('</li><li>', $errors).'</li></ul>';
	}

?>
		<form action="" method="post">
			<label for="login">
				<span>Login:</span>
				<input type="text" id="login" name="login" value="<?php echo (isset($login) ? $login : '') ?>" />
			</label>
			<label for="password">
				<span>Password:</span>
				<input type="password" id="password" name="password" value="<?php echo (isset($password) ? $password : '') ?>" />
			</label>
			<label for="name">
				<span>Name:</span>
				<input type="text" id="name" name="name" value="<?php echo (isset($name) ? $name : '') ?>" />
			</label>
			<label for="email">
				<span>Email:</span>
				<input type="text" id="email" name="email" value="<?php echo (isset($email) ? $email : '') ?>" />
			</label>
			<label for="irc">
				<span>IRC Nick:</span>
				<input type="text" id="irc" name="irc" value="<?php echo (isset($irc) ? $irc : '') ?>" />
			</label>
			<p><input type="submit" value="Submit" name="submit" /></p>
		</form>
<?php

}

include 'footer.php';
