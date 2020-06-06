<?php 
// include_once("login_session.php");
// Display card details for edit page
include_once('game.php');
include_once('card.php');
include_once('new_game_object.php');
include_once('sleeve_empty.php');
include_once('sleeve_groups.php');
include_once('convert_bgg_to_id.php');


if($_SESSION["loggedIn"] && isset($_POST['game'])) {
	
	$game_ID = $_POST['game'];
	game_detail(new_game_object($game_ID));

}

function game_detail($game){
	?>
	<div class="popup-cart"><div class="flex"><div>Success!</div></div></div>
	<form action="" class="cart_item_form">
		<h2><?php echo $game->get_name(); ?></h2>
		<img src="img/<?php echo $game->get_image(); ?>" alt="">

		<input type="text" value="<?php echo $game->get_image(); ?>" name="image">

		<input type="hidden" value="<?php echo $game->get_id(); ?>" name="game_id">
		<input type="text" value="<?php echo $game->get_year(); ?>" name="year">
		<input type="text" value="<?php echo $game->get_edition(); ?>" name="edition">

		<div class="controls">

			<?php if($game->get_accessory()) {
				echo '<span class="submit" id="accessory" data-id="' . $game->get_id() . '" data-value="0">Unaccessory</span>';
			}
			else {
				echo '<span class="submit" id="accessory" data-id="' . $game->get_id() . '" data-value="1">Accessory</span>';
			}
			?>
			<span class="submit" id="delete" data-id="<?php echo $game->get_id(); ?>">Delete</span>

			<?php
			if($game->get_base() != NULL && $game->get_base() != 'NA') {
				?>
				<h3>Base Game: <br /><?php
				$base_game = new_game_object($game->get_base());
				echo $base_game->get_name();
				?>
				</h3>
				<input type="text" value="<?php echo $base_game->get_URL(); ?>" name="base_id">
				<?php
			}
			else {
			?>
				<h3>Base Game: </h3> 
				<input type="text" value="" name="base_id">
			<?php
			}
			?>
			<?php sleeve_groups(); ?>
		</div>
		<div class="table">
			<div class="row">
				<div class="table-cell"><span>Card Nb</span></div>
				<div class="table-cell"><span>Quantity</span></div>
				<div class="table-cell"><span>Sleeve</span></div>
				<div class="table-cell"></div>
			</div>
		  <?php
		  $cards = $game->get_cards();
		  foreach($cards as $card) {
		  	$sleeves = $card->get_sleeves();

		  	foreach($sleeves as $sleeve) {
	  		?>

				<div class="row">
					<div class="table-cell"><input type="number" name="nb[]" value="<?php echo $card->get_card_nb(); ?>" step="1"></div>
					<div class="table-cell"><input type="number" name="quantity[]" value="<?php echo $card->get_nb_cards(); ?>" step="1"></div>
					<div class="table-cell"><?php sleeve_list($sleeve->get_id()); ?></div>
					<div class="table-cell"><span class="remove" data-card_nb="<?php echo $card->get_card_nb(); ?>" data-sleeve_id="<?php echo $sleeve->get_id(); ?>" data-game_id="<?php echo $game->get_id(); ?>">-</span></div>
				</div>

				<?php
		  	}
	  	?>
	  	<?php
		  }
		  sleeve_list_dropdown();
		  ?>
		</div>
		
		<input type="submit" value="Update" class="submit">
	</form>
  <?php
}
?>