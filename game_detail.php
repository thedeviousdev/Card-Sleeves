<?php 
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
if(isset($_GET['game'])) {
	
	$game_ID = $_GET['game'];
	game_detail(new_game_object($game_ID));

}

function game_detail($game){
	?>
	<div class="<?php echo $game->get_id(); ?>">
		<span data-game_id="<?php echo $game->get_id(); ?>" class="btn_remove"><i class="fas fa-times-square"></i></span>
		<div class="wrapper_detail">
			<div><!-- <img src="http://via.placeholder.com/250x350" /> --></div>
			<div>
				<h2><?php echo $game->get_name(); ?></h2>
		  	<sub>Details</sub>
		  	<!-- <p><a href="<?php echo $game->get_URL(); ?>" target="_blank">BoardGameGeek</a></p> -->
		  </div>
	  </div>
	  <div class="wrapper_cards">
	  	<ul>
		  <?php
		  $cards = $game->get_cards();
		  foreach($cards as $card) {
	  	?>
	  	<li>
		  	<div class="cards_size"><p>- <?php echo $card->get_width(); ?><sub>mm</sub> x <?php echo $card->get_height(); ?><sub>mm</sub></p></div>
		  	<div class="cards_number"><p><?php echo $card->get_nb_cards(); ?></p></div>
		  </li>
	  	<?php
		  }
		  ?>
			</ul>
	  </div>
	</div>
  <?php
}
?>