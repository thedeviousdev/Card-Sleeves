<?php 
include_once('directory.php');

function game_exists($id) {
	try {
		$db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE BGGID ='" . $id ."'");
	  if($result->fetchColumn() > 0)
	  	return true;
	  else
	  	return false;
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>