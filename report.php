<?php

include 'common.php';
include 'header.php';

require_login();
$error = false;
$errors = array();

if(isset($_POST['submit'])) {
	$players = array($_POST['winner'], $_POST['loser']);
	global $login;
	if(!in_array($login['id'], $players))
	{
		array_push($errors, "You are trying to report a game you weren't in.");
		$error = true;
	}
	if(array_diff_assoc($players, array_unique($players)))
	{
		array_push($errors, "There is a duplicate player in the reported game.");
		$error = true;
	}
	if(!isset($_FILES['replay'])
		|| $_FILES['replay']['error'] != UPLOAD_ERR_OK
		|| strcasecmp(pathinfo($_FILES['replay']['name'], PATHINFO_EXTENSION),'sc2replay')!=0)
	{
		array_push($errors, "Please upload a .sc2replay file.");
		$error = true;
	}
	if($error == false)
	{
		if ($result = $mysqli->query("INSERT INTO " . $mysql_prefix . "game (winner, loser, time) VALUES (
			'".$mysqli->real_escape_string($players[0])."',
			'".$mysqli->real_escape_string($players[1])."',
			'".time()."'
		)"))
		{
			$replay_location = $replay_dir . '/' . hash('sha1',$mysqli->insert_id) . '.sc2replay';
			move_uploaded_file($_FILES['replay']['tmp_name'], $replay_location);
			chmod($replay_location, 0644);
?>
		<h2>Report Result</h2>
		<p>Congratulations, you have reported the game successfully.</p>
<?php
		} else {
			printf("Error: %s\n", $mysqli->error);
		}
	}
}

?>
		<h2>Report Result</h2>
<?php
	if ($error) {
		echo '<p class="error">Please correct the following errors:</p><ul class="error"><li>'.implode('</li><li>', $errors).'</li></ul>';
	}
?>
		<form action="" method="post" enctype="multipart/form-data">
			<label for="winner">
				<span>Winner:</span>
				<?echo($login['player'])?>
				<input type="hidden" id="winner" name="winner" value="<?echo($login['id'])?>" />
			</label>
			<label for="loser">
				<span>Loser:</span>
				<select id="loser" name="loser">
<?php

if ($result = $mysqli->query("SELECT id, name FROM " . $mysql_prefix . "player ORDER BY name ASC LIMIT 0, 150", MYSQLI_USE_RESULT)) {
	while ($row = $result->fetch_assoc()) {
?>
					<option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
<?php
	}
} else {
	printf("Error: %s\n", $mysqli->error);
}

?>
				</select>
			</label>
			<label for="replay">
				<span>Replay:</span>
				<input type="file" name="replay" id="replay"/>
			</label>
			<p><input type="submit" value="Submit" name="submit" /></p>
		</form>
<?php

include 'footer.php';
