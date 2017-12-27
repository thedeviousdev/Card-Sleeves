<?php

include_once("game_session.php");
include_once("header.php");
include_once("game_detail.php");

$file = 'data/game-list_test.sqlite';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// echo '<pre>';
// print_r($_SESSION); 
// echo '</pre>';

// session_destroy();
?>

		<?php
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
else {
	  $db = new PDO('sqlite:data/game-list_test.sqlite');

	  $result = $db->query('SELECT * FROM Game');
	  ?>

	  <form action="" class="form_search" method="get">
	  	<input type="text" class="game-select" name="game" />
		  <input type="submit" value="Search" />
		</form>
<?php } ?>

		<h3>Search results:</h3>
		<div class="search_result">
		</div>
	</div>

	<aside>
		<h3>Games list:</h3>
		<div class="current_games">
			<?php if(isset($_SESSION['add_games'])){
				$games_arr = $_SESSION['add_games'];

				foreach($games_arr as $game) {
					echo game_detail($game);
				}
			}
			?>
		</div>
	</aside>
</div>
<?php
include("footer.php");
?>