<?php
session_start();

// echo '<pre>';
// print_r($_SESSION); 
// echo '</pre>';

// session_destroy();

include_once("game_session.php");
include_once("header.php");
include_once("game_detail.php");

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
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}
else {
	  $db = new PDO('sqlite:data/game-list.sqlite');

	  $result = $db->query('SELECT * FROM Game');

	  echo '<form action="" class="form_search" method="get"><select data-placeholder="Search for game..." class="game-select" tabindex="1" name="game"><option value=""></option>';

	  foreach($result as $row) {
  	?>
      <option value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?></option>
	  <?php
	  }
	  echo '</select><input type="submit" value="Search" /></form>';
}
?>
<div class="search_result">
	
</div>
<div class="current_games">
	<?php if(isset($_SESSION['add_games'])){
		$games_arr = $_SESSION['add_games'];

		foreach($games_arr as $game) {
			echo game_detail($game);
		}
	}
	?>
</div>
<?php
include("footer.php");
?>