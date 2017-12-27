<?php 
include_once('game.php');
include_once('card.php');
include_once('game_add.php');
if(isset($_GET['game'])) {
	
	$game_ID = $_GET['game'];
	game_detail(game_add($game_ID));

}

function game_detail($game){
	?>
	<div class="<?php echo $game->get_id(); ?>">
		<span data-game_id="<?php echo $game->get_id(); ?>" class="btn_remove"><i class="fas fa-times-square"></i></span>
  	<!-- <img src="http://via.placeholder.com/250x350" /> -->
  	<h2><?php echo $game->get_name(); ?></h2>
  	<sub><?php echo $game->get_edition(); ?></sub>

  	<p><a href="<?php echo $game->get_URL(); ?>">BoardGameGeek</a></p>

	  <?php
	  $cards = $game->get_cards();
	  foreach($cards as $card) {
  	?>

			<h1><?php echo $card->get_nb_cards(); ?></h1>
	  	<p><?php echo $card->get_width(); ?>mm x <?php echo $card->get_height(); ?>mm</p>

  	<?php
	  }
	  ?>
	</div>
  <?php
}
?>