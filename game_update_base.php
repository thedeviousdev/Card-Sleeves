<?php 
// Update the verify status of a game
include_once('game_detail_edit.php');
include_once('new_game_object.php');

function get_id_from_URL($url) {
  $parse = parse_url($url);
  $parts = explode('/', $parse['path']);
  return $parts[2];
}

function update_base($id, $base){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    $db->exec("UPDATE Game SET BaseGame = '" . get_id_from_URL($base)  . "' WHERE Id = '" . $id . "';");

    return game_detail(new_game_object($id));

  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }

}
?>