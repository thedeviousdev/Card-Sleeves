<?php 
// Query DB for game names from search input
// Display game details for the Home page

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

		<div class="search_result">
		<h3>Search results:</h3><br />
		<?php
	  foreach($result as $row) {
  	?>
  	<div class="<?php echo $row['Id']; ?>">
  		<div class="wrapper_img">
		  	<img src="img/<?php echo $row['Image']; ?>" />
	  	</div>
	  	<div class="wrapper_text">
		  	<h2><?php echo $row['Name']; ?></h2>
		  	<sub><?php echo $row['Edition']; ?></sub>

		  	<p><a href="<?php echo $row['URL']; ?>">BoardGameGeek</a></p>
		  	<span data-game_id="<?php echo $row['Id']; ?>" class="btn_add"><i class="fas fa-plus-circle"></i></span>
	  	</div>
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