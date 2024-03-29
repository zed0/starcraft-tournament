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
		<dt>SC2 Name</dt>
		<dd><?php echo htmlspecialchars($row['sc2name']) ?></dd>
		<dt>SC2 Code</dt>
		<dd><?php echo htmlspecialchars($row['code']) ?></dd>
	</dl>
	<div style="clear: both"></div>
<?php
	}
} else {
	printf("Error: %s\n", $mysqli->error);
}
?>
	<h2>Games</h2>
<?
if ($result = $mysqli->query("SELECT SUM(CASE WHEN winner = " . $player . " THEN 1 ELSE 0 END) AS wins, SUM(CASE WHEN loser = " . $player . " THEN 1 ELSE 0 END) AS losses FROM " . $mysql_prefix . "game WHERE winner=".$player." OR loser = ".$player, MYSQLI_USE_RESULT)) {
	while ($row = $result->fetch_assoc()) {
?>
	<h3>Wins <?echo($row['wins']);?></h3>
	<h3>Losses <?echo($row['losses']);?></h3>
<?php
	}
} else {
	printf("Error: %s\n", $mysqli->error);
}
if ($result = $mysqli->query("SELECT id, winner, loser, time FROM " . $mysql_prefix . "game WHERE winner=".$player." OR loser=".$player." ORDER BY time DESC", MYSQLI_STORE_RESULT)) {
	if ($result->num_rows == 0) {
?>
		<p>No games played</p>
<?php
	} else {
?>
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

		while ($row = $result->fetch_assoc()) {
?>
					<tr>
						<td><a href="player.php?player=<?php echo $row['winner'] ?>" ><?php echo getNameFromId($row['winner']) ?></a></td>
						<td><a href="player.php?player=<?php echo $row['loser'] ?>" ><?php echo getNameFromId($row['loser']) ?></a></td>
						<td><?php echo date('d/m/y', $row['time']) ?></td>
						<td><a href="match.php?match=<? echo($row['id'])?>">details</a></td>
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
