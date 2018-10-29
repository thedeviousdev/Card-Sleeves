<?php 
include_once('game_session.php');
// Query DB for game names from search input
// Display game details for the Home page

if(isset($_POST['game'])) {
	$game_name = $_POST['game'];
	if(isset($_POST['page'])) {
		$page = $_POST['page'];
	}
	else 
		$page = 1;

	game_search($game_name, $page);
}

function game_search($g, $page){
	$g = trim($g);
	$g = str_replace("'", "''", $g);

	try {
		$db = new PDO('sqlite:data/games_db.sqlite');

	  $count = $db->query("SELECT COUNT(*) FROM Game WHERE Name LIKE '%" . $g . "%'")->fetchColumn();
	  $limit = $page*50;

	  if($page != 1)
		  $result = $db->query("SELECT * FROM Game WHERE Name LIKE '%" . $g . "%' ORDER BY Name ASC LIMIT 50 OFFSET " . $limit . ";");
		else
		  $result = $db->query("SELECT * FROM Game WHERE Name LIKE '%" . $g . "%' ORDER BY Name ASC LIMIT 50;");


	  ?>

		<div class="search_result" data-current_page="<?php echo $page; ?>" data-game_name="<?php echo $g; ?>">
			<h3>Search results:</h3><br />
			<?php
		  foreach($result as $row) {
	  	?>
	  	<div class="<?php echo $row['Id']; ?>">
	  		<div class="wrapper_img">
			  	<img src="img/<?php echo $row['Image']; ?>" />
		  	</div>
		  	<div class="wrapper_text">
			  	<h2><?php if($row['Verified']) { echo '<i class="fas fa-check-square"></i>'; }; echo $row['Name']; ?></h2>

			  	<p><a href="<?php echo $row['URL']; ?>">BoardGameGeek</a></p>
			  	<span data-game_id="<?php echo $row['Id']; ?>" class="btn_add<?php if(isset($_SESSION['add_games']) && is_game_in_array($_SESSION['add_games'], $row['Id'])) { echo ' rotate'; } ?>"><i class="fas fa-plus-circle"></i></span>
		  	</div>
	  	</div>

		  <?php
		  }
		  if(!$count) {
		  	?>
		  	<div class="no_results">Game has not been added yet. <br /><a href="https://github.com/thedeviousdev/Card-Sleeves" target="_blank">Want to help by adding it? :)</a></div>
			<?php
		  }
		  // Navigation
		  if($count > 50) {
		  	echo '<footer class="navigation">';
		  	if($page != 1) {
					echo '<span data-page="' . ($page - 1) .'" id="previous"><</span>';
				}
				echo '<span data-page="' . ($page + 1) .'" id="next">></span>';
				echo '</footer>';
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