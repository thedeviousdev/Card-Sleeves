<?php

$string = file_get_contents("data/bgg_list.json");
$json = json_decode($string, true);

$file = 'data/games_db.sqlite';
if (file_exists($file)) {

	try {
	  $db = new PDO('sqlite:data/games_db.sqlite');

		echo '<pre>';
		foreach ($json as $game) {

      $parse = parse_url($game['game_url']);
      $parts = explode('/', $parse['path']);
      $bggid = $parts[2];

			print_r($game);

		  $count = $db->query("SELECT * FROM Game WHERE BGGID = '" . $bggid . "'")->fetchColumn();
		  if($count == 0) {
		  	echo 'New game';
		    $db->exec("INSERT INTO Game (Name, Year, URL, Image, BGGID, Verified) VALUES ('" . $game['game_name'] . "', '0', '" . $game['game_url'] . "', '0', '" . $bggid . "', '0');");
				$result = $db->query("SELECT * FROM Game WHERE BGGID = '" . $bggid . "'");
			  foreach($result as $row) {
			  	$id = $row['Id'];

	        foreach ($game['card_nb'] as $key => $sleeve) {
	        	if (strpos($sleeve, '@') !== false) {
		        	$sleeve_data = explode("@", $sleeve);

			        $card_number = trim($sleeve_data[0]);
		        	$sleeve_size = explode("x", $sleeve_data[1]);
			        $width = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[0]));
			        $height = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[1]));

			    		$db->exec("INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $id . "', '" . $card_number . "', '" . $width . "', '" . $height . "');");
			      }
			      else {
			      	$sleeve_size = explode("x", $game['sleeve_size'][$key]);
			        $width = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[0]));
			        $height = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[1]));

			    		$db->exec("INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $id . "', '" . trim($sleeve) . "', '" . $width . "', '" . $height . "');");
			      }
				  }
				}
			}
			else {
		  	echo 'Update game';
				$result = $db->query("SELECT * FROM Game WHERE BGGID = '" . $bggid . "'");
			  foreach($result as $row) {
			  	$id = $row['Id'];

			  	if($row['Verified'] !== 1) {
		    		$db->exec("DELETE FROM GameCards WHERE GameID = '" . $id . "';");

		        foreach ($game['card_nb'] as $key => $sleeve) {
		        	if (strpos($sleeve, '@') !== false) {
			        	$sleeve_data = explode("@", $sleeve);

				        $card_number = trim($sleeve_data[0]);
			        	$sleeve_size = explode("x", $sleeve_data[1]);
				        $width = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[0]));
				        $height = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[1]));

				    		$db->exec("INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $id . "', '" . $card_number . "', '" . $width . "', '" . $height . "');");
				      }
				      else {
				      	$sleeve_size = explode("x", $game['sleeve_size'][$key]);
				        $width = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[0]));
				        $height = trim(preg_replace("/[^0-9.]/", "", $sleeve_size[1]));

				    		$db->exec("INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $id . "', '" . trim($sleeve) . "', '" . $width . "', '" . $height . "');");
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