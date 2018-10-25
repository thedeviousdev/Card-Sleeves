<?php 
// Display card details for edit page
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
if(isset($_POST['game'])) {
	
	$game_ID = $_POST['game'];
	game_detail(new_game_object($game_ID));

}

function game_detail($game){
	?>
	<div class="popup"><div class="flex"><div>Success!</div></div></div>
	<form action="" class="cart_item_form">
		<img src="img/<?php echo $game->get_image(); ?>" alt="">
		<input type="hidden" value="<?php echo $game->get_id(); ?>" name="game_id">
		<h2><?php echo $game->get_name(); ?></h2>
		<h3><?php if($game->get_year() !== '') { echo $game->get_year(); } else { echo '--';}?></h3>
		<div class="controls">
			<?php if($game->get_verified()) {
				echo '<span class="submit" id="verify" data-id="' . $game->get_id() . '" data-value="0">Unverify</span>';
			}
			else {
				echo '<span class="submit" id="verify" data-id="' . $game->get_id() . '" data-value="1">Verify</span>';
			}
			?>
			<span class="submit" id="delete" data-id="<?php echo $game->get_id(); ?>">Delete</span>
		</div>
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
				<div class="table-cell"><input type="number" name="quantity[]" value="<?php echo $card->get_nb_cards(); ?>" step="1"></div>
				<div class="table-cell"><input type="number" name="width[]" value="<?php echo $card->get_width(); ?>" step=".05"></div>
				<div class="table-cell"><input type="number" name="height[]" value="<?php echo $card->get_height(); ?>" step=".05"></div>
				<div class="table-cell"><span class="remove" data-card_id="<?php echo $card->get_id(); ?>">-</span></div>
			</div>
	  	<?php
		  }
		  ?>
			<div class="row">
				<div class="table-cell"><input type="number" name="quantity[]" value="0" step="1"></div>
				<div class="table-cell"><input type="number" name="width[]" value="0" step=".05"></div>
				<div class="table-cell"><input type="number" name="height[]" value="0" step=".05"></div>
				<div class="table-cell"><span class="add">+</span></div>
			</div>
		</div>
		
		<input type="submit" value="Update" class="submit">
	</form>
  <?php
}
?>