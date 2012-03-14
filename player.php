<?php

include 'common.php';
include 'header.php';

$player = intval($_GET['player']);

function getNameFromId($id){
	global $mysql_prefix;
	global $mysqli;
	if($result = $mysqli->query("SELECT name FROM " . $mysql_prefix . "player WHERE id=".$id, MYSQLI_USE_RESULT)){
		$row = $result->fetch_assoc();
		return htmlspecialchars($row['name']);
	} else {
		printf("Error: %s\n", $mysqli->error);
	}
}

if ($result = $mysqli->query("SELECT * FROM " . $mysql_prefix . "player WHERE id=".$player, MYSQLI_USE_RESULT)) {
	while ($row = $result->fetch_assoc()) {
?>
	<h2>Player details: <?php echo htmlspecialchars($row['name']) ?></h2>
	<dl>
		<dt>Name</dt>
		<dd><?php echo htmlspecialchars($row['name']) ?></dd>
		<dt>IRC nick</dt>
		<dd><?php echo htmlspecialchars($row['ircnick']) ?></dd>
		<dt>email</dt>
		<dd><?php echo htmlspecialchars($row['email']) ?></dd>
	</dl>
	<div style="clear: both"></div>
<?php
	}
} else {
	printf("Error: %s\n", $mysqli->error);
}

if ($result = $mysqli->query("SELECT winner, loser, time FROM " . $mysql_prefix . "game WHERE winner=".$player." OR loser=".$player, MYSQLI_STORE_RESULT)) {
	if ($result->num_rows == 0) {
?>
		<h3>Games</h3>
		<p>No games played</p>
<?php
	} else {
?>
	<h3>Games</h3>
	<table>
		<thead>
			<tr>
				<th>Winner</th>
				<th>Loser</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
<?php

		while ($row = $result->fetch_assoc()) {
?>
					<tr>
						<td><a href="player.php?player=<?php echo $row['winner'] ?>" ><?php echo getNameFromId($row['winner']) ?></a></td>
						<td><a href="player.php?player=<?php echo $row['loser'] ?>" ><?php echo getNameFromId($row['loser']) ?></a></td>
						<td><?php echo date('d/m/y', $row['time']) ?></td>
					</tr>
<?php
			}
	}
} else {
	printf("Error: %s\n", $mysqli->error);
}
		
?>
		</tbody>
	</table>
<?php
include 'footer.php';
