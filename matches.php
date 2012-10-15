<?php

include 'common.php';
include 'header.php';

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

if ($result = $mysqli->query("SELECT id, winner, loser, time FROM " . $mysql_prefix . "game ORDER BY time DESC LIMIT 20", MYSQLI_STORE_RESULT)) {
	if ($result->num_rows == 0) {
?>
		<h3>Recent Games</h3>
		<p>No games played</p>
<?php
	} else {
?>
	<h3>Recent Games</h3>
	<table>
		<thead>
			<tr>
				<th>Winner</th>
				<th>Loser</th>
				<th>Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
		$num = 0;
		while ($row = $result->fetch_assoc()) {
?>
					<tr>
						<td><a href="player.php?player=<?php echo $row['winner'] ?>" ><?php echo getNameFromId($row['winner']) ?></a></td>
						<td><a href="player.php?player=<?php echo $row['loser'] ?>" ><?php echo getNameFromId($row['loser']) ?></a></td>
						<td><?php echo date('d/m/y', $row['time']) ?></td>
						<td><a href="match.php?match=<?php echo $row['id'] ?>" >details</a></td>
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
