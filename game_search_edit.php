<?php 
// Query DB for game names from search input
// Display game details for the Edit page

if(isset($_GET['game'])) {
	$game_name = $_GET['game'];
	game_search($game_name);
}

function game_search($g){
	$g = trim($g);

	try {
		$db = new PDO('sqlite:data/game-list_test.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE Name LIKE '%" . $g . "%'");
	  ?>

		<h3>Search results:</h3>
		<div class="search_result">
		<?php
	  foreach($result as $row) {
  	?>

  	<div class="row">
  		<div class="image"><img src="img/<?php echo $row['Image']; ?>" /></div>
  		<div class="title"><?php echo $row['Name']; ?></div>
  		<div class="year"><?php if($row['Year'] !== '') { echo $row['Year']; } else { echo '--';}?></div>
  		<div class="view" data-game_id="<?php echo $row['Id']; ?>"><span class="btn_view">View</i></span></div>
  	</div>
	  <?php
	  }
	  ?>
	  </div>
	  <?php
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>