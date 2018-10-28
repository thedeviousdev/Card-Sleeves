<?php 
include_once("login_session.php");
// Deletes a Card row from the Card DB
// Used on Game editing pages

if(isset($_POST['card_id'])) {

  $card_id = $_POST['card_id'];
  card_delete($card_id);
}

function card_delete($id){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    $db->exec("DELETE FROM GameCards WHERE Id = '" . $id . "';");
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}
?>