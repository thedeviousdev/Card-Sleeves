<?php 
if(isset($_GET['game'])) {
	
	$game_ID = $_GET['game'];
	game_detail_list($game_ID);

}

function game_detail_list($g){

	try {
		$db = new PDO('sqlite:data/game-list_test.sqlite');

	  $result = $db->query("SELECT * FROM Game WHERE Id = '" . $g . "'");

	  foreach($result as $row) {
  	?>
  	<div class="<?php echo $g; ?>">
  		<span data-game_id="<?php echo $g; ?>" class="btn_remove"><i class="fas fa-times-square"></i></span>
	  	<!-- <img src="http://via.placeholder.com/250x350" /> -->
	  	<h2><?php echo $row['Name']; ?></h2>
	  	<sub><?php echo $row['Edition']; ?></sub>

	  	<p><a href="<?php echo $row['URL']; ?>">BoardGameGeek</a></p>

		  <?php 
		  $cards = $db->query("SELECT * FROM GameCards WHERE GameID = '" . $g . "'");

		  foreach($cards as $row) {
	  	?>

				<h1><?php echo $row['CardNumber']; ?></h1>
		  	<p><?php echo $row['Width']; ?>mm x <?php echo $row['Height']; ?>mm</p>

	  	<?php
		  }
		  ?>
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