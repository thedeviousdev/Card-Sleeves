<?php 
// Game details for Cart/Sidebar
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
if(isset($_POST['game'])) {
	
	$game_ID = $_POST['game'];
	cart_item(new_game_object($game_ID));

}

function cart_item($game){
	?>
	<div class="<?php echo $game->get_id(); ?>">
		<span data-game_id="<?php echo $game->get_id(); ?>" class="btn_remove"><i class="fas fa-times-square"></i></span>
		<div class="wrapper_detail">
			<div>
				<h2><a href="<?php echo $game->get_URL(); ?>"target="_blank"><?php echo $game->get_name(); ?> </a></h2>
		  </div>
	  </div>
	  <div class="wrapper_cards">
	  	<ul>
		  <?php
		  $cards = $game->get_cards();
		  foreach($cards as $card) {
	  	?>
	  	<li>
		  	<div class="cards_size"><p><?php echo $card->get_width(); ?><sub>mm</sub> x <?php echo $card->get_height(); ?><sub>mm</sub></p></div>
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