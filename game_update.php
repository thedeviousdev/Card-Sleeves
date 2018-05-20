<?php
$csv_file = "data/games.csv";
$csv = array_map('str_getcsv', file($csv_file));
array_walk($csv, function(&$a) use ($csv) {
  $a = array_combine($csv[0], $a);
});
array_shift($csv); # remove column header


foreach($csv as $game) {
  $id = $game['id'];
  $name = trim($game['name']);
  $year = $game['yearpublished'];
  $min_player = $game['minplayers'];
  $max_player = $game['maxplayers'];
  $url = "https://boardgamegeek.com/boardgame/" . $id;
  $image = $game['image'];

	$extension = pathinfo($image, PATHINFO_EXTENSION);
	if($extension == NULL)
		$extension = 'jpg';

	$clean_name = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $name));

	$path = $clean_name . "." . $extension;

  try {
		$db = new PDO('sqlite:data/game-list_test.sqlite');

  	// $db->exec("UPDATE Game SET URL = '" . $url  . "', Image = '" . $path . "', Year = '" . $year . "' WHERE Name = '" . $name . "';");
  	$db->exec("UPDATE Game SET BGGID = '" . $id  . "' WHERE Name = '" . $name . "';");

  	// echo $name . ': <br />Year: ' . $year . '<br />Image: ' . $path . '<br />URL: ' . $url . '<br />';
  	echo $name . ': ' . $id;
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}

?>