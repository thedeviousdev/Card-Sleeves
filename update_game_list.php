<?php
// include_once("login_session.php");
include_once('directory.php');
// Update games.json game names, used for search bar

function update_json() {
  try {
    $db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');
    $result = $db->query("SELECT * FROM Game");

  	$game_arr = array();

    foreach($result as $row) {
    	$game_arr[] = $row['Name'];
    	// echo $row['Name'];
  	}

    $encoded_rows = array_map('htmlentities', $game_arr);
  	$json_data = json_encode($encoded_rows);
  	file_put_contents(dir_path() . "/data/games.json",$json_data);

    $db = NULL;
    // echo 'done';
  }
  catch(PDOException $e) 	{
    print 'Exception : '. $e->getMessage();
  }
}
?>