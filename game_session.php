<?php 

if(isset($_GET['add_game']) && $_GET['add_game'] != NULL && !in_array($_GET['add_game'], $_SESSION['add_games'])) {
	$add_game_arr = $_SESSION['add_games'];
	$add_game_arr[] = $_GET['add_game'];
	$_SESSION['add_games'] = $add_game_arr;
}


?>