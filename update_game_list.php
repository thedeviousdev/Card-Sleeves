<?php
// Update games.json game names, used for search bar

try {
  $db = new PDO('sqlite:data/game-list_test.sqlite');
  $result = $db->query("SELECT * FROM Game");

	$game_arr = array();

  foreach($result as $row) {
  	$game_arr[] = $row['Name'];
  	echo $row['Name'];
	}

  $encoded_rows = array_map('utf8_encode', $game_arr);
	$json_data = json_encode($encoded_rows);
	file_put_contents("data/games.json",$json_data);

  $db = NULL;
}
catch(PDOException $e) 	{
  print 'Exception : '. $e->getMessage();
}
?>