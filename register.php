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

	if (isset($_POST['sc2name']) && strlen(trim($_POST['sc2name'])) > 1) {
		$sc2name = $_POST['sc2name'];
	} else {
		$error = true;
		array_push($errors, "Enter an SC2 name of at least 2 characters");
	}

	if (isset($_POST['code']) && is_numeric($_POST['code'])) {
		$code = $_POST['code'];
	} else {
		$error = true;
		array_push($errors, "Enter a numeric SC2 code");
	}

	if (!$error) {
		$salt = hash('sha256', mcrypt_create_iv(20));
		$passwordHash = hash('sha256', $salt.$password);
		if ($result = $mysqli->query("INSERT INTO " . $mysql_prefix . "player(login, password, salt, name, sc2name, code, email) VALUES (
			'".$mysqli->real_escape_string($login)."',
			'".$passwordHash."',
			'".$salt."',
			'".$mysqli->real_escape_string($name)."',
			'".$mysqli->real_escape_string($sc2name)."',
			'".$mysqli->real_escape_string($code)."',
			'".$mysqli->real_escape_string($email)."')")) {

?>
		<h2>Register</h2>
		<p>Congratulations, you are now registered, <a href="login.php">click here</a> to continue to login</p>
<?php

		} else {
			$error = true;
			array_push($errors, $mysqli->error);
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
				<span class="details">(as you wish it to be displayed on the site)</span>
			</label>
			<label for="email">
				<span>Email:</span>
				<input type="text" id="email" name="email" value="<?php echo (isset($email) ? $email : '') ?>" />
				<span class="details">(will not be displayed)</span>
			</label>
			<label for="sc2name">
				<span>SC2 Name:</span>
				<input type="text" id="sc2name" name="sc2name" value="<?php echo (isset($sc2name) ? $sc2name : '') ?>" />
			</label>
			<label for="code">
				<span>SC2 Code:</span>
				<input type="text" id="code" name="code" value="<?php echo (isset($code) ? $code : '') ?>" />
				<span class="details">(the number after your name in StarCraft II)</span>
			</label>
			<p><input type="submit" value="Submit" name="submit" /></p>
		</form>
<?php

}

include 'footer.php';
