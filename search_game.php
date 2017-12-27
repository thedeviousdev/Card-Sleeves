<?php 
if(isset($_GET['game'])) {
	
	$game_ID = $_GET['game'];
	game_search($game_ID);

}

function game_search($g){

	try {
		$db = new PDO('sqlite:data/game-list_test.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE Name LIKE '%" . $g . "%'");

	  foreach($result as $row) {
  	?>
  	<div class="<?php echo $row['Id']; ?>">
	  	<!-- <img src="img/<?php echo $row['Image']; ?>" /> -->
	  	<h2><?php echo $row['Name']; ?></h2>
	  	<sub><?php echo $row['Edition']; ?></sub>

	  	<p><a href="<?php echo $row['URL']; ?>">BoardGameGeek</a></p>
	  	<span data-game_id="<?php echo $row['Id']; ?>" class="btn_add"><i class="fas fa-plus-circle"></i></span>
  	</div>
	  <?php
	  }
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>