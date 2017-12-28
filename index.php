<?php

include_once("game_session.php");
include_once("header.php");
include_once("game_detail.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// echo '<pre>';
// print_r($_SESSION); 
// echo '</pre>';

// session_destroy();
?>

		<h3>Search results:</h3>
		<div class="search_result">
		</div>
	</div>

	<aside>
		<h3>Games list:</h3>
		<div class="current_games">
			<?php if(isset($_SESSION['add_games'])){
				$games_arr = $_SESSION['add_games'];

				foreach($games_arr as $game) {
					echo game_detail($game);
				}
			}
			?>
		</div>
		<div class="total_cards">
			<h2>Total:</h2>
		</div>
	</aside>
</div>
<?php
include("footer.php");
?>