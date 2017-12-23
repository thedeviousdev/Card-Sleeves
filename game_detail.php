<?php 
if(isset($_GET['game'])) {

	$game_ID = $_GET['game'];

	try {
		$db = new PDO('sqlite:data/game-list.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE Id = '" . $game_ID . "'");

	  foreach($result as $row) {
  	?>
  	<div>
	  	<img src="" />
	  	<h2><?php echo $row['Name']; ?></h2>
	  	<sub><?php echo $row['Edition']; ?></sub>

			<h1><?php echo $row['CardNumber']; ?></h1>
	  	<p><?php echo $row['Width']; ?>mm x <?php echo $row['Height']; ?>mm</p>
	  	<p><a href="#">BoardGameGeek</a></p>
	  	<input type="button" value="Add" class="btn_add" />
  	</div>
	  <?php
	  }
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}

?>