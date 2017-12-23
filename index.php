<?php
session_start();

if(isset($_GET['game']) && $_GET['game'] != NULL && !in_array($_GET['game'], $_SESSION['games'])) {
	$game_arr = $_SESSION['games'];
	$game_arr[] = $_GET['game'];
	$_SESSION['games'] = $game_arr;
}


echo '<pre>';
print_r($_SESSION); 
echo '</pre>';

// session_destroy();

include("header.php");

$file = 'data/game-list.sqlite';

if (!file_exists($file)) {
	try {
	  $db = new PDO('sqlite:data/game-list.sqlite');
	  $db->exec("CREATE TABLE Game (Id INTEGER PRIMARY KEY, Name TEXT, Edition TEXT, CardNumber TEXT, Width INTEGER, Height INTEGER)");    
		if (($handle = fopen("data/Sleeves.csv", "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	        $num = count($data);

	        $name = $data[0];
	        $edition = NULL;
	        $card_number = $data[1];
	        $width = $data[2];
	        $height = $data[3];

			    $db->exec("INSERT INTO Game (Name, Edition, CardNumber, Width, Height) VALUES ('" . $name . "', '" . $edition . "', '" . $card_number . "', '" . $width . "', '" . $height . "');");

		    }
		    fclose($handle);
		}

	  $db = NULL;
	}
	catch(PDOException $e)
	{
	  print 'Exception : '.$e->getMessage();
	}
}
else {
	  $db = new PDO('sqlite:data/game-list.sqlite');

	  $result = $db->query('SELECT * FROM Game');

	  echo '<form action="" class="form_account" method="get"><select data-placeholder="Search for game..." class="game-select" tabindex="1" name="game"><option value=""></option>';

	  foreach($result as $row) {
  	?>
      <option value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?></option>
	  <?php
	  }
	  echo '</select><input type="submit" value="Submit" /></form>';
}

include("footer.php");
?>