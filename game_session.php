<?php 
// Adding games to cart and save to session
include_once("new_game_object.php");
include_once('game.php');
include_once('card.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['game_id'])) {
	// add_game_to_session($_POST['game_id']);

	$game_ID = $_POST['game_id'];
	$sleeve_array = array();
	$game = new_game_object($game_ID);

	foreach ($_POST as $key => $value) {
		if($key !== 'game_id') {
			$sleeve_array[] = $value;
		}
	}
	$game->set_cart_sleeve($sleeve_array);
	add_game_to_session($game);
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

function add_game_to_session($game) {

	$game_ID = $game->get_id();

	if($game_ID != NULL && !isset($_SESSION['add_games'])) {
		$add_game_arr[] = $game;
		$_SESSION['add_games'] = $add_game_arr;
		echo 'Game added';
	}
	else if($game_ID != NULL && !is_game_in_array($_SESSION['add_games'], $game_ID)) {
		$add_game_arr = $_SESSION['add_games'];
		$add_game_arr[] = $game;
		$_SESSION['add_games'] = $add_game_arr;
		echo 'Game added';
	}
	else if($game_ID != NULL && is_game_in_array($_SESSION['add_games'], $game_ID) && count($_SESSION['add_games']) === 1) {
		remove_game_from_session($game_ID, false);

		$add_game_arr[] = $game;
		$_SESSION['add_games'] = $add_game_arr;
		echo 'Game updated';
	}
	else {
		remove_game_from_session($game_ID);
		
		$add_game_arr = $_SESSION['add_games'];
		$add_game_arr[] = $game;
		$_SESSION['add_games'] = $add_game_arr;
		echo 'Duplicate game found';
	}
}

if(isset($_POST['remove_game'])) {
	remove_game_from_session($_POST['remove_game']);
}

function remove_game_from_session($game_ID, $destroy = true) {

	if(isset($_SESSION['add_games']) && $game_ID != NULL) {
		$add_game_arr = $_SESSION['add_games'];


		foreach($add_game_arr as $key => $game) {

			if($game->get_id() == $game_ID) 
		    unset($add_game_arr[$key]);
		}
		$_SESSION['add_games'] = $add_game_arr;

		if(empty($add_game_arr) && $destroy)
			session_destroy();
	}
}

?>