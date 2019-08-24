<?php
include_once("login_session.php");
include_once("game_update_base.php");
include_once('bgg_search.php');

$string = file_get_contents("data/bgg_list.json");
$json = json_decode($string, true);

$file = 'data/games_db.sqlite';
if (file_exists($file)) {

	try {
	  $db = new PDO('sqlite:data/games_db.sqlite');

		$result = $db->query("SELECT * FROM Game WHERE BaseGame IS NULL LIMIT 2");
		$id_string = '';
	  foreach($result as $row) {
	  	$id = $row['BGGID'];
	  	$id_string .= $id . ',';
	  }
  	bgg_search_expansion($id_string);
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}

function bgg_search_expansion($id){
	$uri = 'https://www.boardgamegeek.com/xmlapi2/thing?id='  . $id;
	echo $id;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	// echo '<pre>';
	// print_r($array);
	// echo '</pre>';
	// echo 'bgg_search_expansion <br/>';

	foreach ($array['item'] as $game) {
		// $xpac_array = array();
		// echo '<pre>';
		// print_r($game);
		// echo '</pre>';
		$base_id = $game['@attributes']['id'];
		$base_url = "https://boardgamegeek.com/boardgame/" . $base_id;

		foreach($game['link'] as $link_fields) {
			// echo '<pre>';
			// print_r($link_fields);
			// echo '</pre>';


			if($link_fields['@attributes']['type'] === 'boardgameexpansion') {
				// $xpac_array[] = $xpac['id'];

				$bgg_xpac_id = $link_fields['@attributes']['id'];

				echo $bgg_xpac_id . '<br/>';

				try {
				  $db = new PDO('sqlite:data/games_db.sqlite');

					$result = $db->query("SELECT * FROM Game WHERE BGGID = " . $bgg_xpac_id);

					$xpac_id = '';
				  foreach($result as $row) {
				  	$xpac_id = $row['Id'];
				  }

				  if($xpac_id !== '') {
				  	echo "if <br>";
				  	update_base($xpac_id, $base_url);
				  }
				  else {
				  	echo "else <br>";
				  	bgg_search($bgg_xpac_id);
				  }

				}
				catch(PDOException $e) 	{
				  print 'Exception : '. $e->getMessage();
				}
			}
		}

		try {
		  $db = new PDO('sqlite:data/games_db.sqlite');

			$result = $db->query("SELECT * FROM Game WHERE BGGID = " . $base_id);

			$orig_id = '';
		  foreach($result as $row) {
		  	$orig_id = $row['Id'];
		  }

      $db->exec("UPDATE Game SET BaseGame = 'NA' WHERE Id = '" . $orig_id . "';");

		}
		catch(PDOException $e) 	{
		  print 'Exception : '. $e->getMessage();
		}
		// return;
	}
}
?>