<?php 
// Update a card's details or add a new card

if(isset($_GET['game_id'])) {
  
  $game_ID = $_GET['game_id'];
  $quantity = $_GET['quantity'];
  $width = $_GET['width'];
  $height = $_GET['height'];
  $card_array = count($quantity); 
  for($i=0; $i<$card_array; $i++) {
    if($quantity[$i] != '0' && $width[$i] != '0' && $height[$i] != '0')
      card_update($game_ID, $quantity[$i], $width[$i], $height[$i]);
  }
}

function card_update($g, $quantity, $width, $height){

  try {
    $db = new PDO('sqlite:data/game-list_test.sqlite');
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