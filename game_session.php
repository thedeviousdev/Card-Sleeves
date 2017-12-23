<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['add_game'])) {
	add_game_to_session($_GET['add_game']);
}

function add_game_to_session($game) {
	if($game != NULL && !isset($_SESSION['add_games'])) {
		$add_game_arr[] = $game;
		$_SESSION['add_games'] = $add_game_arr;

	}
	else if($game != NULL && !in_array($game, $_SESSION['add_games'])) {
		$add_game_arr = $_SESSION['add_games'];
		$add_game_arr[] = $game;
		$_SESSION['add_games'] = $add_game_arr;
	}
}

if(isset($_GET['remove_game'])) {
	remove_game_from_session($_GET['remove_game']);
}

function remove_game_from_session($game) {

	if(isset($_SESSION['add_games']) && $game != NULL && in_array($game, $_SESSION['add_games'])) {
		$add_game_arr = $_SESSION['add_games'];
		if (($key = array_search($game, $add_game_arr)) !== false) {
	    unset($add_game_arr[$key]);
		}
		$_SESSION['add_games'] = $add_game_arr;
	}
}

?>