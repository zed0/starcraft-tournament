<?php

include 'common.php';

$error = false;
$errors = array();
if (isset($_POST['submit'])) {
	if (isset($_POST['login']) && $_POST['login'] != '') {
		$logindetails = $_POST['login'];
	} else {
		$error = true;
		array_push($errors, "Enter your login");
	}

	if (isset($_POST['password']) && $_POST['password'] != '') {
		$password = $_POST['password'];
	} else {
		$error = true;
		array_push($errors, "Enter your password");
	}

	if (!$error) {
		if ($result = $mysqli->query("SELECT id, salt, password FROM " . $mysql_prefix . "player WHERE login='".$mysqli->real_escape_string($logindetails)."' LIMIT 0,1")) {
			$error = true;
			array_push($errors, "Invalid login");
			while ($row = $result->fetch_assoc()) {
				if (hash('sha256',$row['salt'].$password) == $row['password']) {
					$error = false;
					setcookie($cookie_name, base64_encode($logindetails).":".sha1($logindetails.$row['password']));
					//$login = $logindetails;

					header('Location: .');
					exit();
				} else {
					$error = true;
					$errors = array("Invalid login");
				}
			}
		} else {
			include 'header.php';
			printf("Error: %s\n", $mysqli->error);
		}
	}
}

if (!isset($_POST['submit']) || $error) {
	include 'header.php';

?>
		<h2>Login</h2>
<?php

	if ($error) {
		echo '<p class="error">Please correct the following errors:</p><ul class="error"><li>'.implode('</li><li>', $errors).'</li></ul>';
	}

?>
		<form action="" method="post">
				<label for="login">
					<span>Login:</span>
					<input type="text" id="login" name="login" />
				</label>
				<label for="password">
					<span>Password:</span>
					<input type="password" id="password" name="password" />
				</label>
			<p><input type="submit" value="Submit" name="submit" /></p>
		</form>
		
<?php

}

include 'footer.php';
