<?php 
include_once("login_session.php");
include_once('game_update_base.php');
// Update a card's details or add a new card

if(isset($_POST['game_id'])) {
  
  $game_ID = $_POST['game_id'];
  $quantity = $_POST['quantity'];
  $width = $_POST['width'];
  $height = $_POST['height'];
  $card_array = count($quantity); 
  for($i=0; $i<$card_array; $i++) {
    if($quantity[$i] != '0' && $width[$i] != '0' && $height[$i] != '0')
      card_update($game_ID, $quantity[$i], $width[$i], $height[$i]);
  }

  if(isset($_POST['base_id'])) {
    $base_ID = $_POST['base_id'];

    update_base($game_ID, $base_ID);
  }

}


function card_update($g, $quantity, $width, $height, $base_id = NULL){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    // Check for results first
    $check = $db->query("SELECT * FROM GameCards WHERE GameID ='" . $g ."' AND Width ='" . $width . "' AND Height ='" . $height . "';");

    // If there already exists a card, update its quantity
    if ($check->fetchColumn() > 0) {
      $result = $db->query("SELECT * FROM GameCards WHERE GameID ='" . $g ."' AND Width ='" . $width . "' AND Height ='" . $height . "';");

      foreach($result as $row) {
        $id = $row['Id'];
        $old_qty = $row['CardNumber'];

        if($old_qty != $quantity)
          $db->exec("UPDATE GameCards SET CardNumber = '" . $quantity  . "' WHERE Id = '" . $id . "';");
      }
    }
    // Otherwise, add a new card size & quantity
    else {
      if($quantity !== 0 && $width !== 0 && $height !== 0)
        $db->exec("INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $g . "', '" . $quantity . "', '" . $width . "', '" . $height . "');");
    }
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}
?>