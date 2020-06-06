<?php
include_once("login_session.php");
include_once('directory.php');
include_once('convert_bgg_to_id.php');

$string = file_get_contents(dir_path() . "data/games_structure.json");
$json = json_decode($string, true);

foreach ($json as $index => $game) {
	$id = convert_bgg_to_id($index);
	$xpac_string = '';


	foreach($game as $xpac) {
		$xpac_id = convert_bgg_to_id($xpac);
		$xpac_string .= $xpac_id . ',';
	}

	$xpac_string_no_comma = rtrim($xpac_string, ',');

	try {
		$db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');

		$base_result = $db->query("UPDATE Game SET BaseGame = 'NA' WHERE Id = " . $id . ";");
	  $xpac_result = $db->query("UPDATE Game SET BaseGame = '" . $id . "' WHERE Id IN (" . $xpac_string_no_comma . ");");
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
