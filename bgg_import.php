<?php 
// Search BGG using U
include_once("login_session.php");
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
include_once('game_search_edit.php');
include_once('update_game_list.php');
include_once('game_detail_edit.php');
include_once('bgg_search.php');
include_once('game_exists.php');
bgg_list_import();

/*
// TODO: 
- Cronjob
- Handle sizes that don't match
- Handle expansions
- 

Create an empty array to handle all the card sets
Query1: List out all the card sleeve names from the database into an array (save the ID and name)
Query2: Split bgg_content by line breaks
Loop1: Loop through Query2 values
Loop1: Create a counter to track if there are multiple card sizes (you'll know it's another card size if there is a double linebreak (\n\n))
Loop1: If there is a double line break, go through the next line, go through each character until you meet a number, 
save the numbers until you meet any non-number character
Loop1: Save this new number as the number of sleeves for that card type
Loop2: One by one, compare the sleeve names against the values from Loop1
Condition: If the percentage is higher than 80%, assume it is the correct sleeve
Save the ID of the sleeve
Break the loop of Loop2
Insert things
*/

function bgg_list_import() {
	$db = new PDO('sqlite:data/games_db.sqlite');

	$i = 0;
	$bgg_list_id = 164572;
	// $bgg_list_id = 272582; // Smaller list

	// Toggle this to use a exported file from BGG
	if(false) {
		$uri = 'https://www.boardgamegeek.com/xmlapi/geeklist/' . $bgg_list_id;

		$response = file_get_contents($uri);
		$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);

		$json = json_encode($xml);
		
		$file = 'data/export.txt'; 
		$open = fopen( $file, "w" ); 
	  $write = fputs( $open, $json ); 
	  fclose( $open );
		$array = json_decode($json,TRUE);
	}
	else {
		$response = file_get_contents('data/export.txt');
		// For testing purposes
		// $response = file_get_contents('sample_txt.txt');

		$array = json_decode($response, TRUE);
	}

	echo '--------------------------------<br />';
	echo 'Updated games<br />';
	echo "<table border='1' style='border-collapse:collapse;'><tr><td></td><td>Game ID</td><td>BGG ID</td></tr>";

	foreach($array['item'] as $index => &$game) {

		// Get this from the XML
		$bgg_game_id = $game['@attributes']['objectid'];
		$bgg_last_edit_date = $game['@attributes']['editdate'];
		$bgg_content = $game['body'];


		$result = db_find_game_with_bggid($db, $bgg_game_id);

		if($result->fetchColumn() > 0) {
			update_game_details_from_geeklist($db, $index, $bgg_content, $bgg_last_edit_date, $bgg_game_id);
		}
		else {
			// Add Game because it doesn't exist in our DB yet
			bgg_search($bgg_game_id);

			update_game_details_from_geeklist($db, $index, $bgg_content, $bgg_last_edit_date, $bgg_game_id, true);
		}

		// // For sample testing
		// if($i == 3)
		// 	break;
		// $i++;
	}

	echo "</table>";
	echo '--------------------------------<br />';
}

function update_game_details_from_geeklist($db, $index, $bgg_content, $bgg_last_edit_date, $bgg_game_id, $new_entry = false) {
	$game_id = '';

	$result = db_find_game_with_bggid($db, $bgg_game_id);

  foreach($result as $index => $row) {
  	$db_last_edit_date = $row['BGGLastEditDate'];
  	$game_id = $row['Id'];

  	// Only update the entry if the post has been updated
  	if($bgg_last_edit_date !== $db_last_edit_date) {
  		// echo 'dates dont match';
  		db_update_bgg_date($db, $bgg_game_id, $bgg_last_edit_date);
  		$cards = regex_card_data($db, $bgg_content);

  		// Remove all the existing sleeves if it's an old entry
  		if(!$new_entry)
	  		db_delete_cards($db, $game_id);

  		db_insert_cards($db, $game_id, $cards);

			echo "<tr><td>" . $index . "</td><td>" . $game_id . "</td><td>" . $bgg_game_id . "</td></tr>";

  	// 	echo 'Game ID: ' . $bgg_game_id . '<br />';
			// echo '<pre>';
			// print_r($cards);
			// echo '</pre>';
  	}

  	break;
  }
}

function db_find_game_with_bggid($db, $bgg_game_id) {
	try {
		// echo 'try';         
		return $db->query("SELECT * FROM Game WHERE BGGID = '" . $bgg_game_id . "'");
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}

function db_delete_cards($db, $game_id) {
	try {
		return $db->query("DELETE FROM Cards WHERE GameId = " . $game_id );
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}

function stripBBCode($text_to_search) {
 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
 $replace = '';
 return preg_replace($pattern, $replace, $text_to_search);
}

function db_update_bgg_date($db, $bgg_game_id, $new_date) {
	try {
		$db->exec("UPDATE Game SET BGGLastEditDate = '" . $new_date . "' WHERE BGGID = " . $bgg_game_id . " ;");
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}

function multiexplode($delimiters,$string) {
  $ready = str_replace($delimiters, $delimiters[0], $string);
  $launch = explode($delimiters[0], $ready);
  return $launch;
}

function regex_card_data($db, $bgg_content) {
	// $stripped_bgg_content = stripBBCode($bgg_content);

	// similar_text('bafoobar', $stripped_bgg_content, $perc);
	
	/* 
	{
		0: {
			nb: 30,
			cards: [
				{
					id: 66
				},
				{
					id: 20
				}
			]
		},
		1: {
			nb: 30,
			cards: [
				{
					id: 66
				},
				{
					id: 20
				}
			]
		}
	}
	*/
	// Create an empty array to handle all the card sets
	$cards = [];
	$sizes = db_list_sleeves($db);

	// Split bgg_content by line breaks
	$bgg_content_split_by_lines = multiexplode(array("\n"," or "), $bgg_content);

	// Create a counter to track if there are multiple card sizes
	$card_set = 0;
	$card_qty_found = false;
	$nb_of_cards = '';
	$line_break = false;

	// Loop through Query2 values
	foreach($bgg_content_split_by_lines as $line) {

		// Games may have expansions in their description, they are generally indicated by the word 'Expansions' or multiple dashes
		// Currently not handling expansions with the automated script
		if (strpos($line, 'Expansion') !== false && strpos($line, '--') !== false) {
			break;
		}

		// If the line is empty, continue through to the next line
		if(strcmp($line, "") === 0) {
			if(array_key_exists($card_set, $cards) && count($cards[$card_set]['cards'])) {
				$card_qty_found = false;
				$card_set++;
			}

			$line_break = true;
			continue;
		}

		$sleeve_match_found = false;
		foreach($sizes as $index => $size) {
			// If the percentage is higher than 80%, assume it is the correct sleeve

			similar_text($size['name'], $line, $percentage_match);
			if($percentage_match > 97) {
				$cards[$card_set]['cards'][] = array(
					'id' => $size['id'],
					'name' => $size['name'],
				);
				$sleeve_match_found = true;
			}
		}

		// Look for number of cards
		if(!$sleeve_match_found && !$card_qty_found) {
			// echo 'Card qty needed';

			$nb_of_cards = extract_card_qty($line);

			if($nb_of_cards !== 0 && $nb_of_cards !== '') {
				$card_qty_found = true;   
				$cards[$card_set] = array(
					'nbOfCards' => $nb_of_cards,
					'cards' => array()
				);
			}
		}
	}

	return $cards;
}

// List out all the card sleeve names from the database into an array (save the ID and name)
function db_list_sleeves($db) {
	$sizes = [];

	try {
	  $sleeves = $db->query("SELECT Id, BGGName FROM Sleeve" );

		foreach($sleeves as $sleeve) {
			$sizes[] = array(
				'id' => $sleeve['Id'],
				'name' => $sleeve['BGGName']
			);
		}

		return $sizes;
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}

// Look for number of cards
// Do this by looking for the first integer character within a string
// Continue searching the string until a non integer character is found
function extract_card_qty($line) {
	$nb_of_cards = '';
	$line_array = str_split($line);
	$first_digit_found = false;

	foreach($line_array as $character) {

		if(ctype_digit($character)) {
			$nb_of_cards .= $character;
			$first_digit_found = true;
		}
		else if($first_digit_found && !ctype_digit($character)) {
			break;
		}
	}

	return $nb_of_cards;
}

function db_insert_cards($db, $game_id, $cards) {
	// echo '<pre>';
	// print_r($cards);
	// echo '<pre>';
	$values_to_insert = '';

	foreach($cards as $index => $card) {
		foreach($card['cards'] as $sleeve) {
			$values_to_insert .= "(" . $game_id . ", " . $sleeve['id'] . ", " . $index . ", " . $card['nbOfCards'] . "),";
		}
	}
	// Remove the trailing comma
	$values_to_insert = substr($values_to_insert, 0, -1);

	try {
		$db->exec("INSERT INTO Cards ( GameId, SleeveId, CardNb, Quantity )	VALUES " . $values_to_insert . ";");
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}	
}