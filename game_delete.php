<?php 
include_once("login_session.php");
// Delete a game

if(isset($_POST['id'])) {
  
  $game_ID = $_POST['id'];

  game_delete($game_ID);
}

function game_delete($id){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    $db->exec("DELETE FROM Game WHERE Id = '" . $id . "';");

    echo '<div class="popup"><div class="flex"><div>Game removed!</div></div></div>';
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }

}
?>