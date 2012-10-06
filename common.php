<?php

error_reporting(E_ALL);

// Turn off magic_quotes_runtime
if (get_magic_quotes_runtime())
        set_magic_quotes_runtime(0);

// Strip slashes from GET/POST/COOKIE (if magic_quotes_gpc is enabled)
if (get_magic_quotes_gpc())
{
        function stripslashes_array($array)
        {
                return is_array($array) ? array_map('stripslashes_array', $array) : stripslashes($array);
        }

        $_GET = stripslashes_array($_GET);
        $_POST = stripslashes_array($_POST);
        $_COOKIE = stripslashes_array($_COOKIE);
}

// Points config

$base_score = 1000;
// Put some kind of score algorithm here

// Db stuff
include "config.php";

$mysqli = new mysqli("localhost", $mysql_user, $mysql_password, $mysql_db);

// Login stuff
if (isset($_COOKIE[$cookie_name])) {
	$login = $_COOKIE[$cookie_name];
	$login = explode(":", $login);
	$login['player'] = base64_decode($login[0]);
	$loginfail = true;
	
	if ($result = $mysqli->query("SELECT id, password FROM " . $mysql_prefix . "player WHERE login='".$mysqli->real_escape_string($login['player'])."' LIMIT 0,1")) {
		while ($row = $result->fetch_assoc()) {
			if ($login[1] == sha1($login['player'].$row['password'])) {
				$loginfail = false;
				$login['id'] = $row['id'];
			}
		}
	}
	if ($loginfail) {
		unset($login);
		setcookie ($cookie_name, "", time() - 3600);
	}
}

function require_login() {
	global $login;
	if (!isset($login['id'])) {
		echo '<h2>Error</h2><p>Please log in to access this page.</p>';
		include 'footer.php';
		exit();
	}
}
