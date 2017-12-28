<?php
$file = 'data/game-list_test.sqlite';
if (!file_exists($file)) {

	try {
	  $db = new PDO('sqlite:data/game-list_test.sqlite');
	  $db->exec("CREATE TABLE Game (Id INTEGER PRIMARY KEY, Name TEXT, Language TEXT, Year INTEGER, Edition TEXT, URL TEXT, Image TEXT)");

	  $db->exec("CREATE TABLE GameCards (Id INTEGER PRIMARY KEY, GameID INTEGER, CardNumber TEXT, Width INTEGER, Height INTEGER);");


		if (($handle = fopen("data/Sleeves_test.csv", "r")) !== FALSE) {
			$game_arr = array();

	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        $name = $data[0];
        $language = $data[1];
        $year = $data[2];
        $edition = $data[3];
        $image = $data[4];
        $url = $data[5];

	    	$game_arr[] = $name;

		    $db->exec("INSERT INTO Game (Name, Language, Year, Edition, URL, Image) VALUES ('" . $name . "', '" . $language . "', '" . $year . "', '" . $edition . "', '" . $url . "', '" . $image . "');");
		    $pk_id = $db->lastInsertId();

        for ($i = 6; $i < 24; $i+=3) {
        	if($data[$i] != NULL) {
		        $card_number = $data[$i];
		        $width = $data[$i+1];
		        $height = $data[$i+2];

		    		$db->exec("INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $pk_id . "', '" . $card_number . "', '" . $width . "', '" . $height . "');");
		      }
		      else 
		      	break;
			  }


	    }
	    fclose($handle);
		}

    $encoded_rows = array_map('utf8_encode', $game_arr);
		$json_data = json_encode($encoded_rows);
		file_put_contents("data/games.json",$json_data);

	  $db = NULL;
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}


$encoded_rows = array_map('utf8_encode', $game_arr);
$json_data = json_encode($encoded_rows);
file_put_contents("data/games.json",$json_data);