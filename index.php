<?php
session_start();

// echo '<pre>';
// print_r($_SESSION); 
// echo '</pre>';

// session_destroy();

include_once("game_session.php");
include_once("header.php");
include_once("game_detail.php");

$file = 'data/game-list_test.sqlite';
?>

		<?php
if (!file_exists($file)) {
	try {
	  $db = new PDO('sqlite:data/game-list_test.sqlite');
	  $db->exec("CREATE TABLE Game (Id INTEGER PRIMARY KEY, Name TEXT, Language TEXT, Year INTEGER, Edition TEXT, URL TEXT, Image TEXT)");

	  $db->exec("CREATE TABLE GameCards (Id INTEGER PRIMARY KEY, GameID INTEGER, CardNumber TEXT, Width INTEGER, Height INTEGER);");


		if (($handle = fopen("data/Sleeves_test.csv", "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

	        $name = $data[0];
	        $language = $data[1];
	        $year = $data[2];
	        $edition = $data[3];
	        $url = $data[4];
	        $image = $data[5];

			    $db->exec("INSERT INTO Game (Name, Language, Year, Edition, URL, Image) VALUES ('" . $name . "', '" . $language . "', '" . $year . "', '" . $edition . "', '" . $url . "', '" . $image . "');");
			    $pk_id = $db->lastInsertId();

			    echo "INSERT INTO Game (Name, Language, Year, Edition, URL, Image) VALUES ('" . $name . "', '" . $language . "', '" . $year . "', '" . $edition . "', '" . $url . "', '" . $image . "'); <br />";


	        for ($i = 6; $i < 24; $i+=3) {
	        	if($data[$i] != NULL) {
			        $card_number = $data[$i];
			        $width = $data[$i+1];
			        $height = $data[$i+2];

				   		echo "INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $pk_id . "', '" . $card_number . "', '" . $width . "', '" . $height . "');<br />";
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

	  $db = NULL;
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}
else {
	  $db = new PDO('sqlite:data/game-list_test.sqlite');

	  $result = $db->query('SELECT * FROM Game');

	  echo '<form action="" class="form_search" method="get"><select data-placeholder="Search for game..." class="game-select" tabindex="1" name="game"><option value=""></option>';

	  foreach($result as $row) {
  	?>
      <option value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?></option>
	  <?php
	  }
	  echo '</select><input type="submit" value="Search" /></form>';
}

	  $db = new PDO('sqlite:data/game-list_test.sqlite');
	  // print "<table border=1>";
	  // print "<tr><td>Id</td><td>Name</td><td>Edition</td><td>CardNumber</td><td>Width</td><td>Height</td></tr>";
	  // $result = $db->query('SELECT * FROM Game');
	  // foreach($result as $row) {
	  //   print "<tr><td>".$row['Id']."</td>";
	  //   print "<td>".$row['Name']."</td>";
	  //   print "<td>".$row['Language']."</td>";
	  //   print "<td>".$row['Year']."</td>";
	  //   print "<td>".$row['Edition']."</td>";
	  //   print "<td>".$row['URL']."</td>";
	  //   print "<td>".$row['Image']."</td></tr>";
	  // }
	  // print "</table>";

	  print "<table border=1>";
	  print "<tr><td>Id</td><td>Name</td><td>Edition</td><td>CardNumber</td><td>Width</td><td>Height</td></tr>";
	  $result = $db->query('SELECT * FROM GameCards ORDER BY GameID ASC');
	  foreach($result as $row) {
	    print "<tr><td>".$row['Id']."</td>";
	    print "<td>".$row['GameID']."</td>";
	    print "<td>".$row['CardNumber']."</td>";
	    print "<td>".$row['Width']."</td>";
	    print "<td>".$row['Height']."</td></tr>";
	  }
	  print "</table>";
?>
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