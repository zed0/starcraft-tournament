<?php

include 'common.php';
include 'header.php';
include 'phpsc2replay/mpqfile.php';
include 'phpsc2replay/sc2replay.php';

$player = intval($_GET['match']);

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

function createAPMImage($players, $length, $fn) {
	if(file_exists($fn))
	{
		return;
	}
	$width = 300;
	$height = 200;
	$maxapm = 300;
	$pixelsPerSecond = $width/$length;
	$image = new Imagick();
	$image->newImage($width+50, $height+50, new ImagickPixel('none'));
	$draw = new ImagickDraw();
	$draw->setStrokeColor(new ImagickPixel('white'));
	$draw->setStrokeWidth(1.5);
	$draw->setStrokeAntialias(true);
	$draw->setFillColor(new ImagickPixel('none'));
	$draw->setFont('static/EurostileExt-Reg.otf');
	$draw->setTextAlignment(Imagick::ALIGN_RIGHT);
	$draw->setTextAntialias(true);
	$draw->setFontSize(15);
	$draw->setFontStyle(Imagick::STYLE_NORMAL);
	$draw->setFontWeight(100);
	$draw->rectangle(40,0,$width + 40,$height);
	$draw->line(40,$height / 2,$width + 40,$height / 2);
	$image->annotateImage($draw, 15, $height-40, 270, "APM");
	$image->annotateImage($draw, $width/2+20,$height + 40, 0, "Time (minutes)");
	$draw->setFontSize(12);
	$image->annotateImage($draw, 35, $height+10, 0, "0");
	$image->annotateImage($draw, 35,($height / 2)+10, 0, floor($maxapm / 2));
	$image->annotateImage($draw, 35, 10, 0, floor($maxapm));
	$lengthMins = ($length / 60);
	for ($i = 0;$i < $lengthMins;$i+=5) {
		$image->annotateImage($draw, 50+($width/($lengthMins/5) * ($i/5)), $height+15, 0, $i);
		if ($i > 0)
			$draw->line(40+($width / ($lengthMins / 5) * ($i / 5)),0,40+($width / ($lengthMins / 5) * ($i / 5)),$height);
	}

	// first create x/y pairs
	// do this by adding up the actions of the 10 seconds before the pixel
	// if there are less than 60 seconds, extrapolate by multiplying with 10/$secs
	// the time index corresponding to a pixel can be calculated using the $pixelsPerSecond variable,
	// it should always be 0 < $pixelsPerSecond < 1
	foreach($players as $player)
	{
		$draw->setStrokeColor(new ImagickPixel('#'.$player['color']));
		if($player['isObs'])
		{
			continue;
		}
		$vals = $player['apm'];
		$xypair = array();
		//$maxapm = 0;
		for ($x = 1;$x <= $width;$x++) {
			$secs = ceil($x / $pixelsPerSecond);
			$apm = 0;
			if ($secs < 30) {
				for ($tmp = 0;$tmp < $secs;$tmp++)
					if (isset($vals[$tmp]))
						$apm += $vals[$tmp];
				$apm = $apm / $secs * 30;
			} else {
				for ($tmp = $secs - 30;$tmp < $secs;$tmp++)
					if (isset($vals[$tmp]))
						$apm += $vals[$tmp];
				$apm = $apm;
			}
			$apm*=2;
			//if ($apm > $maxapm)
			//	$maxapm = $apm;
			$xypair[$x] = $apm;

		}

		// draw the pixels
		if ($maxapm <= 0)
			return;
		for ($i = 2;$i <= $width;$i++) {
			$draw->line(40+$i - 1,$height - $xypair[$i - 1] / $maxapm * $height, 40+$i,$height - $xypair[$i] / $maxapm * $height);
		}
	}
	// copy the graph onto the container image and save it
	$image->drawImage($draw);
	$shadow = $image->clone();
	$shadow->setImageBackgroundColor(new ImagickPixel('#BBBBFF'));
	$shadow->shadowImage(60, 3, 0, 0);
	$image->compositeImage($shadow, Imagick::COMPOSITE_DSTOVER,-6,-6);
	$image->setImageFormat('png');
	$image->writeImage($fn);
	chmod($fn,0644);
}

if ($result = $mysqli->query("SELECT * FROM " . $mysql_prefix . "game WHERE id=".$player, MYSQLI_STORE_RESULT)) {
	while ($row = $result->fetch_assoc()) {

?>
	<h2>Match details: <?php echo(getNameFromId($row['winner']).' vs '.getNameFromId($row['loser']))?> </h2>
	<dl>
		<dt>Winner</dt>
		<dd><a href="player.php?player=<?php echo($row['winner'])?>"><?php echo(getNameFromId($row['winner']))?></a></dd>
		<dt>Loser</dt>
		<dd><a href="player.php?player=<?php echo($row['loser'])?>"><?php echo(getNameFromId($row['loser']))?></a></dd>
<?
		$replayname = hash('sha1', $row['id']).'.sc2replay';
		$replaypath = $replay_dir.'/'.$replayname;
		if(file_exists($replaypath))
		{
			$mpqfile = new MPQFile($replaypath);
			$replay = $mpqfile->parseReplay();
			$players = $replay->getPlayers();
?>
		<dt>Replay</dt>
		<dd><a href="<? echo($replaypath)?>">link</a></dd>
		<dt>Map</dt>
		<dd><?echo($replay->getMapName())?></dd>
		<dt>Length</dt>
		<dd><?echo($replay->getFormattedGameLength())?></dd>
		<dt>Details</dt>
		<dd>
			<table>
				<tr>
					<th>Player name</th>
					<th>Race</th>
					<th>Color</th>
					<th>Average APM</th>
				</tr>
<?
			foreach($players as $value) {
				if ($value['isObs']) {
					if ($obsString == "")
						$obsString = $value['name'];
					else
						$obsString .= ', '.$value['name'];
					$obsCount++;
					continue;
				}
				if ($replay->isWinnerKnown())
					$wincolor = (isset($value['won']) && $value['won'] == 1)?0x00FF00:0xFF0000;
				else
					$wincolor = 0xFFFFFF;
				if ($value['isComp'] && $replay->getTeamSize() !== null)
					$difficultyString = sprintf(" (%s)",SC2Replay::$difficultyLevels[$value['difficulty']]);
				else
				{
					$difficultyString = "";
?>
				<tr>
					<td><a href="http://www.sc2ranks.com/eu/<?echo($value['uid'])?>/<?echo($value['name'])?>">
						<?echo($value['name'].$difficultyString)?>
					</a></td>
					<td><?echo($value['race'])?></td>
					<td style='color:#<?echo($value['color'])?>;'><?echo($value['sColor'])?></td>
					<td><?echo(($value['team'] > 0)?(round($value['apmtotal'] / ($replay->getGameLength() / 60))):0)?></td>
<?
				}
			}
?>
			</table>
		</dd>
		<dt>APM</dt>
<?
			$apmname = 'static/'.hash('sha1', $row['id']).'.png';
			createAPMImage($players, $replay->getGameLength(), $apmname);
?>
		<dd><img src="<?echo($apmname)?>" /></dd>
<?
		}
?>
	</dl>
<?
	}
} else {
	printf("Error: %s\n", $mysqli->error);
}

include 'footer.php';
