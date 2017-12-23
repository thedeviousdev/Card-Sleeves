<?php 
if(isset($_GET['game'])) {
	
	$game_ID = $_GET['game'];
	game_detail($game_ID);

}

function game_detail($g){

	try {
		$db = new PDO('sqlite:data/game-list.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE Id = '" . $g . "'");

	  foreach($result as $row) {
  	?>
  	<div class="<?php echo $g; ?>">
	  	<img src="" />
	  	<h2><?php echo $row['Name']; ?></h2>
	  	<sub><?php echo $row['Edition']; ?></sub>

			<h1><?php echo $row['CardNumber']; ?></h1>
	  	<p><?php echo $row['Width']; ?>mm x <?php echo $row['Height']; ?>mm</p>
	  	<p><a href="#">BoardGameGeek</a></p>
	  	<span data-game_id="<?php echo $g; ?>" class="btn_remove">Remove</span>
	  	<span data-game_id="<?php echo $g; ?>" class="btn_add">Add</span>
  	</div>
	  <?php
	  }
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>