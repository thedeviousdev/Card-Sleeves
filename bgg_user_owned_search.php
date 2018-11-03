<?php 
// Search BGG using U
// include_once('game_session.php');
include_once("new_game_object.php");
include_once('game.php');
include_once('card.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if(isset($_POST['username'])) {
	$username = $_POST['username'];
	bgg_search($username);
}

// Check if game exists in the array
function is_game_in_array($game_arr, $new_game){
	if(!$game_arr) {
		foreach($game_arr as &$game) {
			if($game->get_id() == $new_game) {
				return true;
			}
		}
	}
	return false;
}


function bgg_search($username){
	$uri = 'https://boardgamegeek.com/xmlapi2/collection?username='  . $username;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	$show_result = '';
	// echo '<pre>';
	// print_r($array);
	// echo '</pre>';

	if($array['@attributes']['totalitems'] != 0) {
		foreach($array['item'] as &$game) {
			if($game['status']['@attributes']['own'] == 1) {
				$games_added = add_game_to_array($game['@attributes']['objectid']);
				if($games_added == 'Game added')
					$show_result = 'Game added';
			}
		}
		echo $show_result;
	}
	else 
		echo 'Invalid';

}

function add_game_to_array($game_ID) {
	$id = convert_bgg_to_id($game_ID);
	if($id !== false) {

		if(!isset($_SESSION['add_games'])) {
			$add_game_arr[] = new_game_object($id);
			$_SESSION['add_games'] = $add_game_arr;
			return 'Game added';
		}
		else if(!is_game_in_array($_SESSION['add_games'], new_game_object($id))) {
			$add_game_arr = $_SESSION['add_games'];
			$add_game_arr[] = new_game_object($id);
			$_SESSION['add_games'] = $add_game_arr;
			return 'Game added';
		}
		else {
			return 'Duplicate game found';
		}
	}
	else
		return 'Game does not exist';
}

function convert_bgg_to_id($bggid) {
	$id = false;
	$db = new PDO('sqlite:data/games_db.sqlite');

  $result = $db->query("SELECT * FROM Game WHERE BGGID ='" . $bggid ."'");
  foreach($result as $row) {
  	$id = $row['Id'];
  }

  return $id;
}