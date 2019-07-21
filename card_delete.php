<?php 
include_once("login_session.php");
// Deletes a Card row from the Card DB
// Used on Game editing pages

if(isset($_POST['sleeve_id'])) {

  $sleeve_id = $_POST['sleeve_id'];
  $card_nb = $_POST['card_nb'];
  $game_id = $_POST['game_id'];
  card_delete($game_id, $sleeve_id, $card_nb);
}

function card_delete($g, $sleeve_id, $card_nb){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    $db->exec("DELETE FROM Cards WHERE GameId = '" . $g . "' AND SleeveId = '" . $sleeve_id ."' AND CardNb = '" . $card_nb ."';");
    echo "DELETE FROM Cards WHERE GameId = '" . $g . "' AND SleeveId = '" . $sleeve_id ."' AND CardNb = '" . $card_nb;
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}
?>