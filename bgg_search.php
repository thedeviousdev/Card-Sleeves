<?php 
// Search BGG using U
include_once("login_session.php");
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
include_once('game_search_edit.php');
include_once('update_game_list.php');
include_once('game_detail_edit.php');
include_once('game_exists.php');

if(isset($_POST['url'])) {
	
	$url = $_POST['url'];
	$parse = parse_url($url);
	$parse_base = NULL;

	if($_POST['base'] !== "") {
		$base = $_POST['base'];
		$parse_base = parse_url($base);
	}

	if($parse['host'] == 'boardgamegeek.com' && $parse_base !== "") {
		$parts = explode('/', $parse['path']);
		bgg_search($parts[2]);
	}
	else if ($parse_base['host'] == 'boardgamegeek.com') {
		$parts = explode('/', $parse['path']);
		$parts_base = explode('/', $parse_base['path']);
		bgg_search($parts[2], $parts_base[2]);
	}
	else {
		?>
		<div class="popup-cart" style="display: flex;"><div class="flex"><div>werwerewPlease enter a valid Board Game Geek URL</div></div></div>
		<?php
	}
}

function bgg_search($id, $base_id = NULL){
	$uri = 'https://www.boardgamegeek.com/xmlapi2/thing?id='  . $id;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	// echo '<pre>';
	// print_r($array);
	// echo '</pre>';
	$thumbnail = $array['item']['image'];

	if (array_key_exists(0, $array['item']['name']))
		$name = $array['item']['name'][0]['@attributes']['value'];
	else
		$name = $array['item']['name']['@attributes']['value'];

	$year = $array['item']['yearpublished']['@attributes']['value'];

	// Before adding this into the DB, check to see if it exists already
	if(!game_exists($id)) {
		if($base_id != NULL)
			add_game($id, $name, $year, $thumbnail, $base_id);
		else
			add_game($id, $name, $year, $thumbnail);
	}
	else {
		?>
		<div class="popup-cart" style="display: flex;"><div class="flex"><div>That game already exists!</div></div></div>
		<?php
	}
}

function add_game($bgg, $name, $year, $image, $base_id = NULL) {
	$url = 'https://boardgamegeek.com/boardgame/' . $bgg;
	$image_path = download_image($name, $image, $year);

	if($image_path != false) {
		try {
			$db = new PDO('sqlite:data/games_db.sqlite');
			if($base_id != NULL)
				$db->exec('INSERT INTO Game (Name, Year, URL, Image, BGGID, Verified, BaseGame) VALUES ("' . $name . '", "' . $year . '", "' . $url . '", "' . $image_path . '", "' . $bgg . '", 0, "' . $base_id . '");');
			else
				$db->exec('INSERT INTO Game (Name, Year, URL, Image, BGGID, Verified, BaseGame) VALUES ("' . $name . '", "' . $year . '", "' . $url . '", "' . $image_path . '", "' . $bgg . '", 0, 0);');

		  $game_id = $db->lastInsertId();
		  ?>

			<div class="popup-cart" style="display: flex;"><div class="flex"><div>Game successfully added!</div></div></div>
			<?php

			update_json();
		}
		catch(PDOException $e) 	{
		  print 'Exception : '. $e->getMessage();
		}
	}
}

function download_image($name, $image_url, $year){

	$extension = pathinfo($image_url, PATHINFO_EXTENSION);
	$clean_name = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $name));

	$path = $clean_name . $year . "." . $extension;

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