<?php 
// include_once("login_session.php");
include_once('game_update_base.php');
// Update a card's details or add a new card

if($_SESSION["loggedIn"] && isset($_POST['game_id'])) {
  
  $game_ID = $_POST['game_id'];
  
  $sleeve = $_POST['sleeve'];
  $quantity = $_POST['quantity'];
  $card_nb = $_POST['nb'];

  $card_array = count($quantity);

  for($i=0; $i<$card_array; $i++) {
    if($quantity[$i] != '0')
      card_update($game_ID, $quantity[$i], $card_nb[$i], $sleeve[$i]);
  }

  if(isset($_POST['base_id'])) {
    $base_ID = $_POST['base_id'];

    update_base($game_ID, $base_ID);
  }

  if(isset($_POST['image']) && $_POST['image'] !== NULL && $_POST['image'] !== "") {
    $image = $_POST['image'];

    update_image($game_ID, $image);
  }

  if(isset($_POST['edition'])) {
    $edition = $_POST['edition'];

    update_edition($game_ID, $edition);
  }

  if(isset($_POST['year'])) {
    $year = $_POST['year'];

    update_year($game_ID, $year);
  }

}

function update_image($g, $image){
  echo 'update_image';
  try {
    $db = new PDO('sqlite:data/games_db.sqlite');

    $check = $db->query("SELECT * FROM Game WHERE Id ='" . $g ."';");
    if ($check->fetchColumn() > 0) {

      $result = $db->query("SELECT * FROM Game WHERE Id ='" . $g ."';");
      foreach($result as $row) {
        $old_image = $row['Image'];

        if($old_image != $image)
          $db->exec("UPDATE Game SET Image = '" . $image  . "' WHERE Id = '" . $g . "';");
      }
    }
    return game_detail(new_game_object($g));
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}


function update_edition($g, $edition){
  echo 'update_edition';
  try {
    $db = new PDO('sqlite:data/games_db.sqlite');

    $check = $db->query("SELECT * FROM Game WHERE Id ='" . $g ."';");
    if ($check->fetchColumn() > 0) {

      $result = $db->query("SELECT * FROM Game WHERE Id ='" . $g ."';");
      foreach($result as $row) {
        $old_edition = $row['Edition'];

        if($old_edition != $edition)
          $db->exec("UPDATE Game SET Edition = '" . $edition  . "' WHERE Id = '" . $g . "';");
      }
    }
    return game_detail(new_game_object($g));
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}

function update_year($g, $year){
  echo 'update_year';
  try {
    $db = new PDO('sqlite:data/games_db.sqlite');

    $check = $db->query("SELECT * FROM Game WHERE Id ='" . $g ."';");
    if ($check->fetchColumn() > 0) {

      $result = $db->query("SELECT * FROM Game WHERE Id ='" . $g ."';");
      foreach($result as $row) {
        $old_year = $row['Year'];

        if($old_year != $year)
          $db->exec("UPDATE Game SET Year = '" . $year  . "' WHERE Id = '" . $g . "';");
      }
    }
    return game_detail(new_game_object($g));
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}

function card_update($g, $quantity, $card_nb, $sleeve_id, $base_id = NULL){

  try {
    $db = new PDO('sqlite:data/games_db.sqlite');
    // Check for results first
    $check = $db->query("SELECT * FROM Cards WHERE GameID ='" . $g ."' AND SleeveId ='" . $sleeve_id . "' AND CardNb ='" . $card_nb . "';");

    // If there already exists a card, update its quantity
    if ($check->fetchColumn() > 0) {
      $result = $db->query("SELECT * FROM Cards WHERE GameID ='" . $g ."' AND SleeveId ='" . $sleeve_id . "' AND CardNb ='" . $card_nb . "';");

      foreach($result as $row) {
        $id = $row['Id'];
        $old_qty = $row['Quantity'];
        $old_card_nb = $row['CardNb'];
        $old_sleeve_id = $row['SleeveId'];

        // echo "UPDATE Cards SET Quantity = '" . $quantity . "' WHERE GameId = '" . $g . "' AND CardNb = '" . $card_nb  . "';";

        if($old_qty != $quantity || $old_card_nb != $card_nb || $old_sleeve_id != $sleeve_id ) {

          $db->exec("UPDATE Cards SET Quantity = '" . $quantity . "' WHERE GameId = '" . $g . "' AND CardNb = '" . $card_nb  . "';");
        }
      }
    }
    // Otherwise, add a new card size & quantity
    else {
      $db->exec("INSERT INTO Cards (GameId, SleeveId, CardNb, Quantity) VALUES ('" . $g . "', '" . $sleeve_id . "', '" . $card_nb . "', '" . $quantity . "');");
    }
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}
?>