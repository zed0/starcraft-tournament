<?php

include 'common.php';

include 'header.php';

?>
		<br />
		<br />
		Welcome to the <a href="http://uwcs.co.uk">UWCS</a> friendly Starcraft II ladder.<br />
		This is a ladder for Warwick students; if you are a Warwick student and would like to join the ladder then just register above, have a read over the rules and join the channel "UWCS" in the Starcraft II client.
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
		player.id,
		player.name AS name,
		SUM(CASE WHEN game.winner = player.id THEN 1 ELSE 0 END) AS wins,
		SUM(CASE WHEN game.loser = player.id THEN 1 ELSE 0 END) AS losses,
		SUM(CASE WHEN game.winner = player.id THEN 3 WHEN game.loser = player.id THEN 1 ELSE 0 END) as rating
	FROM " . $mysql_prefix . "player AS player
	LEFT JOIN " . $mysql_prefix . "game AS game
	ON player.id=game.winner OR player.id=game.loser
	GROUP BY player.id
	ORDER BY rating DESC"
	, MYSQLI_USE_RESULT)) {
	$rank = 0;
	$backup = 0;
	$score = INF;
	while ($row = $result->fetch_assoc()) {
		if($score > $row['rating'])
		{
			$rank += 1 + $backup;
			$backup = 0;
		}
		else
		{
			$backup++;
		}
		$score = $row['rating'];
?>
				<tr>
					<td><?php echo $rank ?></td>
					<td><a href="player.php?player=<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['name']) ?></a></td>
					<td><?php echo $row['rating'] ?></td>
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
