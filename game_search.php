<?php 
include_once('game_session.php');
include_once('new_game_object.php');

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

function expansion_search($g) {
	try {
		$db = new PDO('sqlite:data/games_db.sqlite');

	  $count = $db->query("SELECT COUNT(*) FROM Game WHERE BaseGame = '" . $g . "'")->fetchColumn();
	  $result = $db->query("SELECT * FROM Game WHERE BaseGame = '" . $g . "'");

	  $html = NULL;

		if($count != 0) { 
			$html .= "<ul>";

		  foreach($result as $key => $expansion) {

		  	$expansion_obj = new_game_object($expansion['Id']);

		  	$expansion_id = $expansion_obj->get_id();
		  	$expansion_name = $expansion_obj->get_name();

		  	$html .= '<li><a href="#" data-game_id="' . $expansion_id . '" class="open_game">' . $expansion_name . '</a></li>';
		  } 
			$html .= "</ul>";
		  return $html;
		}
		else {
			return FALSE;
		}

	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

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
      <div class="popup-cart">
        <div class="flex"><div></div></div>        
      </div>
			<h3>Search results:</h3><br />
			<div class="cards">
				
			<?php
		  foreach($result as $row) {

		  	$game = new_game_object($row['Id']);
		  	$base_game = NULL;
		  	$game_expansions = expansion_search($game->get_id());
				$cards = $game->get_cards();

		  	if($game->get_base() != '') {
			  	$base_game = new_game_object($game->get_base());
			  }

	  	?>
	    <div class="card is-collapsed" id="<?php echo $game->get_id(); ?>">
	      <div class="card-inner  js-expander">
		  		<div class="wrapper_img">
		  			<img src="img/<?php echo $game->get_image(); ?>" alt="">
			  	</div>
			  	<div class="wrapper_text">
				  	<h2><?php echo $game->get_Name(); ?></h2>
				  	<sub><?php echo $game->get_year(); if ($game->get_edition() != ""){ echo " - " . $game->get_edition(); }?></sub>
			  	</div>
	      </div>
	      <div class="card-expander">
		  		<span class="card-expander-close"><i class="fas fa-times-circle"></i></span>
		  		<div class="card-expander-game-details">
				  	<div class="card-expander-game-details-wrapper-text">
					  	<h2><?php echo $game->get_name(); ?></h2>
					  	<p><strong>Year:</strong> <?php echo $game->get_year(); ?></p>
  						<p><strong>Edition:</strong> <?php if($game->get_edition() != '') { echo $game->get_edition(); } else { echo '--';}?></p>
					  	<p><strong>BoardGameGeek: </strong><a href="<?php echo $game->get_URL(); ?>" target="_blank">Link</a></p>
  						<p><strong>Base Game:</strong> <?php if($base_game != NULL) { echo '<a href="#" class="open_game" data-game_id="' . $base_game->get_id() . '">' . $base_game->get_name() . '</a>'; } else { echo '--';}?></p>
  						<p><strong>Expansions:</strong> <?php if($game_expansions !== FALSE) { echo $game_expansions; } else { echo '--';}?></p>
	  					</p>

				  	</div>			  			
		  		</div>
		  		<?php
	  				if($cards) {
			  		?>
			  		<div class="card-expander-game-cards">
							<form action="" class="card-expander-game-cards-form">

								<input type="hidden" name="game_id" value="<?php echo $game->get_id(); ?>">

				  			<?php
			  				foreach($cards as $key => $card) {
			  					?>
			  					<div class="card-expander-game-cards-form-sleeve">
										<h2>Card <?php echo ++$key; ?></h2>
			  						<h3><?php echo $card->get_nb_cards(); ?></h3>

			  						<div class="card-expander-game-cards-form-sleeve-wrapper">
		  								
											<select name="<?php echo $card->get_id(); ?>">
											<?php
											$sleeves = $card->get_sleeves();
											foreach($sleeves as $sleeve) {
												?>
											  <option value="<?php echo $sleeve->get_id(); ?>"><?php echo $sleeve->get_brand() . ' | ' . $sleeve->get_name(); ?></option>
											<?php
											}
											?>		
											</select>
			  						</div>
			  					</div>
			  					<?php
			  				}
				  			?>
				  			<div class="card-expander-game-cards-form-submit">
									<button type="submit" value="Submit" class="card-expander-game-cards-form-submit-button">Add Sleeves</button>	  				
				  			</div>
							</form>
			  		</div>

			  	<?php 
				  }	else {
		  		?>

			  		<div class="card-expander-no-cards">
			  			<span>No cards recorded for this game! <a href="https://github.com/thedeviousdev/Card-Sleeves" target="_blank">Want to help by adding it? :)</a></span>
			  		</div>
			  		<?php
			  	}
			  	?>
		  		<div class="commentbox" id="game_<?php echo $game->get_id(); ?>"></div>
	      </div>
	    </div>



		  <?php
		  } 
		  ?>
			</div>
			<?php
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