<?php 
// Search BGG using U
// include_once('game_session.php');
include_once("new_game_object.php");
include_once('game.php');
include_once('card.php');
include_once('game_search.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function bgg_search($username){
	$uri = 'https://boardgamegeek.com/xmlapi2/collection?username='  . $username;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	$user_game_string = '';

	if(array_key_exists('@attributes', $array) && $array['@attributes']['totalitems'] != 0) {
		foreach($array['item'] as &$game) {
			if($game['status']['@attributes']['own'] == 1) {
				$user_game_string .= $game['@attributes']['objectid'] . ",";
			}
		}
	}
	else {
		return false;
	}
	return rtrim($user_game_string, ',');
}