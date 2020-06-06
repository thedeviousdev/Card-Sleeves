<?php 
include_once('directory.php');

function sleeve_brands_form() {
	try {
		$db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');

	  $result = $db->query("SELECT * FROM SleeveCompany");

		echo '<form class="game-brand-selector"><select name="company">';
    foreach($result as $row) {
		  echo '<option value="' . $row['Id'] . '">' . $row['Name'] . '</option>';
		}
		echo '</select></form>';
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}
?>