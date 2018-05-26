<?php 
if(isset($_GET['game_id'])) {
  
  $game_ID = $_GET['game_id'];
  game_search($game_ID);

}

function card_update($g, $quantity, $width, $height){

  try {
    $db = new PDO('sqlite:data/game-list_test.sqlite');
    $result = $db->query("SELECT * FROM Card WHERE GameID ='" . $g ."', Width ='" . $width . "', Height ='" . $height . "';");
    if ($result->fetchColumn() > 0) {
      // If there are results, check if any exist with the current width & height, if so, adjust quantity if it's different

      foreach($result as $row) {
        $id = $row['Id'];
        $old_qty = $row['quantity'];
        if($old_qty != $quantity)
          $db->exec("UPDATE Card SET CardNumber = '" . $quantity  . "' WHERE Id = '" . $id . "';");
      }
    }
    else {
      // Otherwise, create a new card row
      $db->exec("INSERT INTO GameCards (GameID, CardNumber, Width, Height) VALUES ('" . $g . "', '" . $quantity . "', '" . $width . "', '" . $height . "');");
    }
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }

}
?>