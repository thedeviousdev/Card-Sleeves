<?php 
// Update the accessory status of a game
include_once('game_detail_edit.php');
include_once('new_game_object.php');

if(isset($_POST['accessory'])) {
  
  $game_ID = $_POST['id'];
  $accessory = $_POST['accessory'];

  update_accessory($game_ID, $accessory);
}

function update_accessory($id, $accessory){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    $db->exec("UPDATE Game SET Accessory = '" . $accessory  . "' WHERE Id = '" . $id . "';");

    return game_detail(new_game_object($id));

  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }

}
?>