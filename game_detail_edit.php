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
	<form action="">
		<img src="img/<?php echo $game->get_image(); ?>" alt="">
		<input type="hidden" value="<?php echo $game->get_id(); ?>" name="id">
		<h2><?php echo $game->get_name(); ?></h2>
		<h3><?php if($game->get_year() !== '') { echo $game->get_year(); } else { echo '--';}?></h3>
		<!-- <input type="text" name="title" disabled value="<?php echo $game->get_name(); ?>">
		<input type="text" name="year" disabled value="<?php echo $game->get_year(); ?>"> -->
		<div class="table">
			<div class="row">
				<div class="table-cell"><span>Quantity</span></div>
				<div class="table-cell"><span>Width (mm)</span></div>
				<div class="table-cell"><span>Height (mm)</span></div>
				<div class="table-cell"></div>
			</div>
		  <?php
		  $cards = $game->get_cards();
		  foreach($cards as $card) {
	  	?>
			<div class="row">
				<div class="table-cell"><input type="number" name="quantity" value="<?php echo $card->get_nb_cards(); ?>"></div>
				<div class="table-cell"><input type="number" name="width" value="<?php echo $card->get_width(); ?>"></div>
				<div class="table-cell"><input type="number" name="height" value="<?php echo $card->get_height(); ?>"></div>
				<div class="table-cell"><span class="remove">-</span></div>
			</div>
	  	<?php
		  }
		  ?>
			<div class="row">
				<div class="table-cell"><input type="number" name="quantity" value="0"></div>
				<div class="table-cell"><input type="number" name="width" value="0"></div>
				<div class="table-cell"><input type="number" name="height" value="0"></div>
				<div class="table-cell"><span class="add">+</span></div>
			</div>
		</div>
		
		<input type="submit" value="Update" class="submit">
	</form>
  <?php
}
?>