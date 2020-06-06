<?php
include_once("login_session.php");
include_once('directory.php');

$string = file_get_contents(dir_path() . "/data/new_3.json");
$json = json_decode($string, true);

$file = dir_path() . '/data/games_db.sqlite';

$sleeve_brands[0] = null;
$sleeve_brands[1] = "Mayday";
$sleeve_brands[2] = "Arcane Tinmen";
$sleeve_brands[3] = "Artipia";
$sleeve_brands[4] = "BCW";
$sleeve_brands[5] = "Blackfire";
$sleeve_brands[6] = "Docsmagic";
$sleeve_brands[7] = "Dragon Shield";
$sleeve_brands[8] = "Fantasy Flight";
$sleeve_brands[9] = "Game Plus";
$sleeve_brands[10] = "Kaissa";
$sleeve_brands[11] = "KMC";
$sleeve_brands[12] = "LaTCG";
$sleeve_brands[13] = "Legion";
$sleeve_brands[14] = "Mage Company";
$sleeve_brands[15] = "MTL";
$sleeve_brands[16] = "Paladin";
$sleeve_brands[17] = "Sleeve Kings";
$sleeve_brands[18] = "Swan PanAsia";
$sleeve_brands[19] = "Tasty Minstrel";
$sleeve_brands[20] = "Ultimate Guard";
$sleeve_brands[21] = "Ultra-Pro";

if (file_exists($file)) {

	try {
	  $db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');

		echo '<pre>';
		foreach ($json as $game) {

			// Get the BGGID from the URL
      $parse = parse_url($game['game_url']);
      $parts = explode('/', $parse['path']);
      $bggid = $parts[2];

			// print_r($game);

			// Check to see if any games already exist with BGGID
		  $count = $db->query("SELECT * FROM Game WHERE BGGID = '" . $bggid . "'")->fetchColumn();

		  // No games exist yet
		  if($count == 0) {
		  	echo 'New game';
		    $db->exec("INSERT INTO Game (Name, Year, URL, Image, BGGID, Verified) VALUES ('" . $game['game_name'] . "', '0', '" . $game['game_url'] . "', '0', '" . $bggid . "', '0');");

		    // Get ID of the game's row
				$result = $db->query("SELECT * FROM Game WHERE BGGID = '" . $bggid . "'");
			  foreach($result as $row) {
			  	$game_id = $row['Id'];

			  	// Iterate through all the sleeves
	        foreach ($game['sleeves'] as $sleeve) {
	        	if($sleeve['sleeve_brand'] === 'Paladin') {
		        		
		        	$brand_key = array_search($sleeve['sleeve_brand'], $sleeve_brands);
		        	$nb_cards = $sleeve['card_total'];
		        	$sleeve_size = $sleeve['sleeve_size'];
		        	$card_nb = $sleeve['card_nb'];

		        	// Don't insert 0 totals
		        	if($nb_cards != 0 && $nb_cards !== '?') {
			        	// Get all of the sleeve sizes from all the companies
								$sleeve_result = $db->query("SELECT * FROM Sleeve WHERE CompanyID = '" . $brand_key . "'");

							  foreach($sleeve_result as $sleeve_row) {
				        	$sleeve_id = $sleeve_row['Id'];
				        	$sleeve_name = $sleeve_row['SleeveName'];

				        	// If the sleeve name is in the sleeve string
									$pos = strpos($sleeve_size, $sleeve_name);

									if ($pos !== false) {
					    			$db->exec("INSERT INTO Cards (GameId, SleeveId, CardNb, Quantity) VALUES ('" . $game_id . "', '" . $sleeve_id . "', '" . $card_nb . "', '" . $nb_cards . "');");
					    			break;
									}
							  }
							}
						}
				  }
				}
			}
			else {
		  	echo 'Update game';
				$result = $db->query("SELECT * FROM Game WHERE BGGID = '" . $bggid . "'");
			  foreach($result as $row) {
			  	$game_id = $row['Id'];

			  	// Iterate through all the sleeves
	        foreach ($game['sleeves'] as $sleeve) {
	        	if($sleeve['sleeve_brand'] === 'Paladin') {

		        	$brand_key = array_search($sleeve['sleeve_brand'], $sleeve_brands);
		        	$nb_cards = $sleeve['card_total'];
		        	$sleeve_size = $sleeve['sleeve_size'];
		        	$card_nb = $sleeve['card_nb'];

		        	// Don't insert 0 totals
		        	if($nb_cards != 0 && $nb_cards !== '?') {
			        	// Get all of the sleeve sizes from all the companies
								$sleeve_result = $db->query("SELECT * FROM Sleeve WHERE CompanyID = '" . $brand_key . "'");

							  foreach($sleeve_result as $sleeve_row) {
				        	$sleeve_id = $sleeve_row['Id'];
				        	$sleeve_name = $sleeve_row['SleeveName'];

				        	// echo '<br>sleeve_size: ' . $sleeve_size;
				        	// echo '<br>sleeve_name: ' . $sleeve_name;

				        	// If the sleeve name is in the sleeve string
									$pos = strpos($sleeve_size, $sleeve_name);

									if ($pos !== false) {

					        	echo '<br>sleeve_size: ' . $sleeve_size;
					        	echo '<br>sleeve_name: ' . $sleeve_name;

					    			$db->exec("INSERT INTO Cards (GameId, SleeveId, CardNb, Quantity) VALUES ('" . $game_id . "', '" . $sleeve_id . "', '" . $card_nb . "', '" . $nb_cards . "');");
									}
							  }
							}
	        	}
				  }
				}
			}
		}
		echo '</pre>';
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>