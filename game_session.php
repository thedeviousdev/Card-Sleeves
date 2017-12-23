<?php 
session_start();

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

?>