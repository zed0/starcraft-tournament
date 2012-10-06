#!/usr/bin/php
<?php

include('config.php');
//games table
$query = 'CREATE TABLE ' . $mysql_prefix . 'game
	(
		id INT(11) NOT NULL AUTO_INCREMENT,
		winner INT(11) NOT NULL,
		loser INT(11) NOT NULL,
		time INT(11) NOT NULL,
		PRIMARY KEY(id)
	)';
if($result = $mysqli->query($query))
{
	echo("Games table created.\n");
}
else
{
	echo($mysqli->error."\n");
	die("Could not create games table!\n");
}

//players table
$query = 'CREATE TABLE ' . $mysql_prefix . 'player
	(
		id INT(11) NOT NULL AUTO_INCREMENT,
		login VARCHAR(255) UNIQUE,
		password CHAR(64),
		salt CHAR(64),
		name VARCHAR(255),
		ircnick VARCHAR(255),
		email VARCHAR(255),
		PRIMARY KEY(id)
	)';
if($result = $mysqli->query($query))
{
	echo("Players table created.\n");
}
else
{
	echo($mysqli->error."\n");
	die("Could not create players table!\n");
}

//reports table
$query = 'CREATE TABLE ' . $mysql_prefix . 'report
	(
		gameid INT(11) NOT NULL,
		playerid INT(11) NOT NULL,
		winner INT(11) NOT NULL,
		loser INT(11) NOT NULL,
		PRIMARY KEY(gameid)
	)';
if($result = $mysqli->query($query))
{
	echo("Reports table created.\n");
}
else
{
	echo($mysqli->error."\n");
	die("Could not create reports table!\n");
}
