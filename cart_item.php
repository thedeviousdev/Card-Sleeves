<?php 
// Game details for Cart/Sidebar
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
if(isset($_POST['game_id'])) {
	
	$game_ID = $_POST['game_id'];
	$sleeve_array = array();
	$game = new_game_object($game_ID);

	foreach ($_POST as $key => $value) {
		if($key !== 'game_id') {
			$sleeve_array[] = $value;
		}
	}
	$game->set_cart_sleeve($sleeve_array);
	cart_item($game);

}

function cart_item($game){
	$cart_sleeves = $game->get_cart_sleeve();
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
				$sleeves = $card->get_sleeves();
				$card_number = $card->get_nb_cards();

				foreach($cart_sleeves as $sleeve_id) {
				  foreach($sleeves as $sleeve) {
				  	if($sleeve->get_id() === $sleeve_id) {
				  	?>
				  	<li>
					  	<div class="cards_size"><p><?php echo $sleeve->get_brand() . " - " . $sleeve->get_name(); ?></p></div>
					  	<div class="cards_number"><p><strong><?php echo $card->get_nb_cards(); ?></strong></p></div>
					  </li>
				  	<?php
				  	}
				  }					
				}
		  }
		  ?>
			</ul>
	  </div>
	</div>
  <?php
}
?>