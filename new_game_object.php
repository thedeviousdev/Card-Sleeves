<?php 
// Create Game object w/ Cards

include_once('directory.php');
include_once('game.php');
include_once('card.php');
include_once('sleeve.php');

function new_game_object($g){

	try {
		$db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE Id = '" . $g . "'");

	  foreach($result as $game) {

		  $nb_of_cards_query = $db->query("SELECT COUNT(DISTINCT CardNb) AS NbOfCards FROM Cards WHERE GameId = '" . $g . "'");
		  $nb_of_cards = NULL;
		  $cards_arr = array();

		  foreach($nb_of_cards_query as $nb_of_card) {
		  	$nb_of_cards = $nb_of_card['NbOfCards'];
		  }

		  for($i = 0; $i < $nb_of_cards; $i++) {
			  $sleeves_arr = array();
			  $quantity = NULL;
			  $card_id = NULL;
			  $card_nb = NULL;

			  $sleeves = $db->query("SELECT Cards.Id, Cards.GameId, Cards.SleeveId, Cards.CardNb, Cards.Quantity, Sleeve.CompanyID, Sleeve.SleeveName, SleeveCompany.Name
					FROM Cards 
					INNER JOIN Sleeve ON Cards.SleeveId = Sleeve.Id
					INNER JOIN SleeveCompany ON Sleeve.CompanyID = SleeveCompany.Id
					WHERE Cards.GameId ='" . $g . "' AND Cards.CardNb = '" . $i . "'
					ORDER BY SleeveCompany.Name;");


			  foreach($sleeves as $sleeve) {
			  	$card_id = $sleeve['Id'];
			  	$card_nb = $sleeve['CardNb'];
			  	$quantity = $sleeve['Quantity'];
			  	$new_sleeve = new sleeve($sleeve['SleeveName'], $sleeve['Name'], $sleeve['SleeveId']);
			  	$sleeves_arr[] = $new_sleeve;
			  }

		  	$new_card = new card($quantity, $sleeves_arr, $card_id, $card_nb);
		  	$cards_arr[] = $new_card;

		  }


	  	$new_game = new game($g, $game['Name'], $game['Year'], $game['Image'], $game['URL'], $cards_arr, $game['Verified'], $game['BaseGame'], $game['Edition'], $game['Accessory']);
		  return $new_game;
	  }
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>