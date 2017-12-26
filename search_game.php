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
  	<div class="<?php echo $g; ?>">
	  	<img src="img/<?php echo $row['Image']; ?>" />
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
	  	<span data-game_id="<?php echo $g; ?>" class="btn_add"><i class="fas fa-plus-circle"></i></span>
  	</div>
	  <?php
	  }
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}
?>