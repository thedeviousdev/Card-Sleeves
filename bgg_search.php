<?php 
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');

if(isset($_GET['url'])) {
	
	$url = $_GET['url'];
	$parse = parse_url($url);
	if($parse['host'] == 'boardgamegeek.com') {
		$parts = explode('/', $parse['path']);
		bgg_search($parts[2]);
	}

}

function bgg_search($id){
	$uri = 'https://www.boardgamegeek.com/xmlapi2/thing?id='  . $id;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);

	$thumbnail = $array['item']['thumbnail'];
	$name = $array['item']['name'][0]['@attributes']['value'];
	$year = $array['item']['yearpublished']['@attributes']['value'];
	$min_players = $array['item']['minplayers']['@attributes']['value'];
	$max_players = $array['item']['maxplayers']['@attributes']['value'];

	// Before adding this into the DB, check to see if it exists already
}

function check_db($id) {
	
}
?>