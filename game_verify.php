<?php 
// Update the verify status of a game
include_once('game_detail_edit.php');
include_once('new_game_object.php');

if(isset($_POST['verify'])) {
  
  $game_ID = $_POST['id'];
  $verify = $_POST['verify'];

  update_verify($game_ID, $verify);
}

function update_verify($id, $verify){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    $db->exec("UPDATE Game SET Verified = '" . $verify  . "' WHERE Id = '" . $id . "';");

    return game_detail(new_game_object($id));

  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }

}
?>