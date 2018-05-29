<?php 
include_once("new_game_object.php");
include_once('game.php');
include_once('card.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['add_game'])) {
	add_game_to_session($_GET['add_game']);
}

// Check if game exists in the array
function is_game_in_array($game_arr, $new_game){

	foreach($game_arr as $game) {
		if($game->get_id() == $new_game) {
			return true;
		}
	}
	return false;
}

function add_game_to_session($game_ID) {

	if($game_ID != NULL && !isset($_SESSION['add_games'])) {
		$add_game_arr[] = new_game_object($game_ID);
		$_SESSION['add_games'] = $add_game_arr;
		echo 'Game added';
	}
	else if($game_ID != NULL && !is_game_in_array($_SESSION['add_games'], $game_ID)) {
		$add_game_arr = $_SESSION['add_games'];
		$add_game_arr[] = new_game_object($game_ID);
		$_SESSION['add_games'] = $add_game_arr;
		echo 'Game added';
	}
	else {
		echo 'Duplicate game found';
	}
}

if(isset($_GET['remove_game'])) {
	remove_game_from_session($_GET['remove_game']);
}

function remove_game_from_session($game_ID) {

	if(isset($_SESSION['add_games']) && $game_ID != NULL) {
		$add_game_arr = $_SESSION['add_games'];


		foreach($add_game_arr as $key => $game) {

			if($game->get_id() == $game_ID) 
		    unset($add_game_arr[$key]);
		}
		$_SESSION['add_games'] = $add_game_arr;

		if(empty($add_game_arr))
			session_destroy();
	}
}

?>