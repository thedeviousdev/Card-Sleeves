<?php
include_once('directory.php');

$file = dir_path() . '/data/games_db.sqlite';
if (file_exists($file)) {

	try {
	  $db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');

		$result = $db->query("SELECT * FROM Game WHERE BaseGame IS NULL LIMIT 500");
		$id_string = '';
	  foreach($result as $row) {
	  	$id = $row['BGGID'];
	  	$id_string .= $id . ',';
	  }
  	bgg_search_expansion($id_string);
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}

function bgg_search_expansion($id){
	$uri = 'https://www.boardgamegeek.com/xmlapi2/thing?id='  . $id;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);

	$game_array = [];

	foreach ($array['item'] as $game) {
		// $xpac_array = array();
		// echo '<pre>';
		// print_r($game);
		// echo '</pre>';
		$base_id = $game['@attributes']['id'];

		$expansion_array = [];

		foreach($game['link'] as $link_fields) {
			if($link_fields['@attributes']['type'] === 'boardgameexpansion') {
				$bgg_xpac_id = $link_fields['@attributes']['id'];
				$expansion_array[] = $bgg_xpac_id;
			}
		}

		$game_array[$base_id] = $expansion_array;
	}

	echo json_encode($game_array);

	set_db_status($id);
}

function set_db_status($g) {
	$string_no_comma = rtrim($g, ',');

	try {
	  $db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');
	  $result = $db->query("UPDATE Game SET BaseGame = 'Done' WHERE BGGID IN (" . $string_no_comma . ");");
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}
?>