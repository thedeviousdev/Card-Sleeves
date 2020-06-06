<?php 
// Return a string of the sleeve size
include_once('directory.php');

if(isset($_POST['sleeve_id'])) {
  $sleeve_ID = filter_var(trim($_POST['sleeve_id']), FILTER_SANITIZE_NUMBER_INT);

  get_sleeve_size($sleeve_ID);
}

function get_sleeve_size($id){
  try {
    $db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');
    $result = $db->query("SELECT * FROM Sleeve WHERE Id = '" . $id . "';");

    $width = '';
    $height = '';

    foreach($result as $row) {
      $width = $row['Width'];
      $height = $row['Height'];
    }

    echo $width . "mm x " . $height . "mm";
  }
  catch(PDOException $e)  {
    print 'Exception : '. $e->getMessage();
  }
}
?>