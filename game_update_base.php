<?php 
// Update the verify status of a game
include_once('game_detail_edit.php');
include_once('new_game_object.php');
include_once('game_exists.php');
include_once('convert_bgg_to_id.php');

function get_id_from_URL($url) {
  $parse = parse_url($url);
  $parts = explode('/', $parse['path']);
  return $parts[2];
}

function update_base($id, $base){
  $base_id = get_id_from_URL($base);

  echo $base_id;

  if(game_exists($base_id) || $base_id == NULL) {
    try {
      $db = new PDO('sqlite:data/games_db.sqlite');

      $non_bgg_id = convert_bgg_to_id($base_id);

      $db->exec("UPDATE Game SET BaseGame = '" . $non_bgg_id  . "' WHERE Id = '" . $id . "';");

      return game_detail(new_game_object($id));

    }
    catch(PDOException $e)  {
      print 'Exception : '. $e->getMessage();
    }
  }
  else {
    return false;
  }

}
?>