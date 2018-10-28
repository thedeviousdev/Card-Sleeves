<?php
include_once("login_session.php");
// Populates Game & Card DB for the first time from CSV file
// Populates Sleeve sizes
// TODO: Add more company alternatives
$file = 'data/games_db.sqlite';
if (!file_exists($file)) {

	try {
	  $db = new PDO('sqlite:data/games_db.sqlite');
	  $db->exec("CREATE TABLE Game (Id INTEGER PRIMARY KEY, Name TEXT, Language TEXT, Year INTEGER, Edition TEXT, URL TEXT, Image TEXT, BGGID INTEGER, Verified INTEGER DEFAULT 0)");

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

	try {
	  $db = new PDO('sqlite:data/games_db.sqlite');
	  $db->exec("CREATE TABLE SleeveCompany (Id INTEGER PRIMARY KEY, Name TEXT)");
	  $db->exec("INSERT INTO SleeveCompany (Name) VALUES ('Mayday Games');");
	  $pk_sleeve_id = $db->lastInsertId();

	  $db->exec("CREATE TABLE Sleeve (Id INTEGER PRIMARY KEY, CompanyID INTEGER, SleeveName TEXT, Width INTEGER, Height INTEGER);");


		if (($handle = fopen("data/Sleeves_Mayday.csv", "r")) !== FALSE) {
			$game_arr = array();

	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

		    $name = $data[0];
		    $width = $data[1];
		    $height = $data[2];

		  	$game_arr[] = $name;
				$db->exec("INSERT INTO Sleeve (CompanyID, SleeveName, Width, Height) VALUES ('" . $pk_sleeve_id . "', '" . $name . "', '" . $width . "', '" . $height . "');");

	    }
	    fclose($handle);
		}

	  $db = NULL;
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
