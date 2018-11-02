<?php
include_once("cart_item.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['total'])) {
	update_cart_contents();
}

function update_cart_contents() {
	if(isset($_SESSION['add_games'])){
		$games_arr = $_SESSION['add_games'];

		foreach($games_arr as $game) {
			echo cart_item($game);
		}
	}
}
?>