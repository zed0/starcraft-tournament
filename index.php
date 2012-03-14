<?php

include 'common.php';

include 'header.php';

?>
		<h2>Current Standings</h2>
		
		<table>
			<thead>
				<tr>
					<th>Ranking</th>
					<th>Name</th>
					<th>Score</th>
					<th>Wins</th>
					<th>Losses</th>
				</tr>
			</thead>
			<tbody>
<?php

if ($result = $mysqli->query(
	"SELECT
	p.id as id,
	p.name as name,
	SUM(CASE WHEN g.winner = p.id THEN 1 ELSE 0 END) wins,
	SUM(CASE WHEN g.loser = p.id THEN 1 ELSE 0 END) losses
	FROM " . $mysql_prefix . "player p, " . $mysql_prefix . "game g
	GROUP BY p.id
	", MYSQLI_USE_RESULT)) {
	$rank = 1;
	while ($row = $result->fetch_assoc()) {
?>
				<tr>
					<td><?php echo $rank++ ?></td>
					<td><a href="player.php?player=<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['name']) ?></a></td>
					<td><?php echo $row['wins'] - $row['losses'] ?></td>
					<td><?php echo $row['wins'] ?></td>
					<td><?php echo $row['losses'] ?></td>
				</tr>
<?php
	}
} else {
	printf("Error: %s\n", $mysqli->error);
}

?>
			</tbody>
		</table>
<?php

include 'footer.php';
