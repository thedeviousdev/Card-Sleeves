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
	  	<span data-game_id="<?php echo $game_ID; ?>" class="btn_add">Add</span>
  	</div>
	  <?php
	  }
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}
}

?>