<?php 
if(isset($_GET['card_id'])) {

  $card_id = $_GET['card_id'];
  card_delete($card_id);
}

function card_delete($id){

  try {
    $db = new PDO('sqlite:data/game-list_test.sqlite');
    $db->exec("DELETE FROM GameCards WHERE Id = '" . $id . "';");
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}
?>