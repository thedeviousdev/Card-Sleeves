<?php 
// Search BGG using U
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
include_once('game_search_edit.php');
include_once('update_game_list.php');
include_once('game_detail_edit.php');

if(isset($_GET['url'])) {
	
	$url = $_GET['url'];
	$parse = parse_url($url);
	if($parse['host'] == 'boardgamegeek.com') {
		$parts = explode('/', $parse['path']);
		bgg_search($parts[2]);
	}
	else {
		?>
		<div class="popup" style="display: flex;"><div class="flex"><div>Please enter a valid Board Game Geek URL</div></div></div>
		<?php
	}
}

function bgg_search($id){
	$uri = 'https://www.boardgamegeek.com/xmlapi2/thing?id='  . $id;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	// echo '<pre>';
	// print_r($array);
	// echo '</pre>';
	$thumbnail = $array['item']['thumbnail'];

	if (array_key_exists(0, $array['item']['name']))
		$name = $array['item']['name'][0]['@attributes']['value'];
	else
		$name = $array['item']['name']['@attributes']['value'];

	$year = $array['item']['yearpublished']['@attributes']['value'];

	// Before adding this into the DB, check to see if it exists already
	if(!game_exists($id)) {
		// game_search($id);
		add_game($id, $name, $year, $thumbnail);
	}
	else {
		?>
		<div class="popup" style="display: flex;"><div class="flex"><div>That game already exists!</div></div></div>
		<?php
	}
}

function game_exists($id) {
	try {
		$db = new PDO('sqlite:data/game-list_test.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE BGGID ='" . $id ."'");
	  if($result->fetchColumn() > 0)
	  	return true;
	  else
	  	return false;
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}

function add_game($bgg, $name, $year, $image) {
	$url = 'https://boardgamegeek.com/boardgame/' . $bgg;
	$image_path = download_image($name, $image);

	if($image_path != false) {
		try {
			$db = new PDO('sqlite:data/game-list_test.sqlite');
			$db->exec('INSERT INTO Game (Name, Year, URL, Image, BGGID, Verified) VALUES ("' . $name . '", "' . $year . '", "' . $url . '", "' . $image_path . '", "' . $bgg . '", 0);');

		  $game_id = $db->lastInsertId();
		  ?>

			<div class="popup" style="display: flex;"><div class="flex"><div>Game successfully added!</div></div></div>
			<?php

			update_json();
		}
		catch(PDOException $e) 	{
		  print 'Exception : '. $e->getMessage();
		}
	}
}

function download_image($name, $image_url){

	$extension = pathinfo($image_url, PATHINFO_EXTENSION);
	$clean_name = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $name));

	$path = $clean_name . "." . $extension;

	if (!file_exists($path)) {
		$download = file_get_contents($image_url);

		if($download === false){
			return false;
		}
		else {
		  file_put_contents('img/' . $path, $download);
		  return $path;
		}
	}
	else {
		return $path;
	}
}