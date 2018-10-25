<?php
// Home page layout

include_once("game_session.php");
include_once("header.php");
include_once("cart_item.php");
include_once("game_total.php");

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

?>
		<div class="contribute">
			<a href="https://github.com/thedeviousdev/Card-Sleeves" target="_blank">
				<i class="fab fa-github"></i><br />
				<span>Contribute?</span>
			</a>
		</div>
	</div>

	<aside>
		<h3>Games list: <span><i class="fas fa-arrow-circle-up"></i></span></h3>
		<div class="current_games">
			<?php if(isset($_SESSION['add_games'])){
				$games_arr = $_SESSION['add_games'];

				foreach($games_arr as $game) {
					echo cart_item($game);
				}
			}
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
	</aside>
</div>
<?php
include("footer.php");
?>