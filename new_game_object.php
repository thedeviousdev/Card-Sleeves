<?php 
// Create Game object w/ Cards

include_once('game.php');
include_once('card.php');

function new_game_object($g){

	try {
		$db = new PDO('sqlite:data/games_db.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE Id = '" . $g . "'");

	  foreach($result as $game) {

		  $cards = $db->query("SELECT * FROM GameCards WHERE GameID = '" . $g . "'");
		  $cards_arr = array();

		  foreach($cards as $card) {
		  	$new_card = new card($card['CardNumber'], $card['Width'], $card['Height'], $card['Id']);
		  	$cards_arr[] = $new_card;
		  }

	  	$new_game = new game($g, $game['Name'], $game['Year'], $game['Image'], $game['URL'], $cards_arr, $game['Verified']);
		  return $new_game;
	  }
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>