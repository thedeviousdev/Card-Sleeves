<?php
// Home page layout

include_once("game_session.php");
include_once("header.php");
include_once("cart_total.php");
include_once("game_total.php");

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

?>
		<div class="contribute">
			<div class="how">
				Using the search bar or import button, add the games from your collection to the cart.<br />
				Once all the games have been added, refer to the Total's section to purchase all the sleeves you need!
			</div>
			<a href="https://github.com/thedeviousdev/Card-Sleeves" target="_blank">
				<i class="fab fa-github"></i><br />
				<span>Contribute?</span>
			</a>
		</div>
	</div>

	<aside>
		<h3><span>Games list: </span><span class="reveal"><i class="fas fa-arrow-circle-up"></i></span><button id="clear" class="submit">Reset</button></h3>
		<div class="current_games">
			<?php
			update_cart_contents();
			?>
		</div>
		<div class="total">
			<h4>Total:</h4>
			<sub>(Mayday Sleeves)</sub>

			<div class="total_cards">
				<?php 
				get_total_sleeves();
				?>
			</div>
		</div>
		<div class="popup user_import">
			<div class="flex">
				<div>
					<span class="close"><i class="fas fa-times-square"></i></span>
					<form action="" class="bgg_user_import">
						<h3>Enter Board Game Geek Username</h3>
						<span class="error">Invalid Username</span>
						<input type="text" name="username" value="" placeholder="" id="username">
						
						<input type="submit" value="Search" class="submit">
					</form>
				</div>
			</div>
		</div>

	</aside>
</div>
<?php
include("footer.php");
?>