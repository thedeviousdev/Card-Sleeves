<?php 
// include_once("login_session.php");
include_once('directory.php');
// Use the BGGID to get the ID

function convert_bgg_to_id($bggid) {
  $id = false;
  $db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');

  $result = $db->query("SELECT * FROM Game WHERE BGGID ='" . $bggid ."'");
  foreach($result as $row) {
    $id = $row['Id'];
  }

  return $id;
}