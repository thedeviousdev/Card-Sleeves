<?php
// To update games that were added before I saved the BGG ID

try {
  $db = new PDO('sqlite:data/game-list_test.sqlite');
  $result = $db->query("SELECT * FROM Game");

  foreach($result as $row) {
    $url = $row['URL'];
    $id = $row['Id'];
    $name = $row['Name'];
    if($row['URL'] != "") {
      $parse = parse_url($url);
      $parts = explode('/', $parse['path']);
      $bggid = $parts[2];
        echo 'Name:' . $name . ' BGGID: ' . $bggid .' url: ' . $url . '</br>';

      try {
        $db->exec("UPDATE Game SET BGGID = '" . $bggid  . "' WHERE Id = '" . $id . "';");
      }
      catch(PDOException $e)  {
        print 'Exception : '. $e->getMessage();
      }
    }
  }

  $db = NULL;
}
catch(PDOException $e)  {
  print 'Exception : '. $e->getMessage();
}
?>