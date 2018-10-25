<?php 
// Tally cards in cart

include_once('game.php');
include_once('card.php');
include_once('sleeve.php');
include_once('new_game_object.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['total'])) {
	get_total_sleeves();
}

function set_sleeve($company_ID) {

	$db = new PDO('sqlite:data/game-list_test.sqlite');
  $result = $db->query("SELECT * FROM Sleeve WHERE CompanyID = '" . $company_ID . "'");

  $sleeve_arr = array();

  foreach($result as $card) {
  	$sleeve_arr[] = new sleeve($card['SleeveName'], $card['Width'], $card['Height']);
  }
  return $sleeve_arr;
}

function get_sleeve_name($card) {

	$card_width = $card->get_width();
	$card_height = $card->get_height();

	$sleeve_arr = set_sleeve('1');

	$best_sleeve_name = NULL;
	$best_difference = -1;
	$temp_difference = -1;

	foreach($sleeve_arr as $sleeve) {

		$sleeve_name = $sleeve->get_name();
		$sleeve_width = $sleeve->get_width();
		$sleeve_height = $sleeve->get_height();

		if($card_width <= $sleeve_width && $card_height <= $sleeve_height) {
			$temp_difference = ($sleeve_width - $card_width) + ($sleeve_height - $card_height);
			$temp_difference = (int)$temp_difference;
		}

		if($temp_difference == 0) {
			$best_sleeve_name = $sleeve_name;
			$best_difference = $temp_difference;
			break;

		}
		if($best_difference == -1 || $temp_difference < $best_difference) {
			$best_sleeve_name = $sleeve_name;
			$best_difference = $temp_difference;
		}

	}

	return $best_sleeve_name;	
}

function get_total_sleeves() {
	if(isset($_SESSION['add_games'])) {
		$game_arr = $_SESSION['add_games'];
		$sleeve_arr = array();

		foreach($game_arr as $key => $game) {

			$card_arr = $game->get_cards();

			foreach($card_arr as $key => $card) {
				$sleeve_name = get_sleeve_name($card);
				$sleeve_number = $card->get_nb_cards();

				if (array_key_exists($sleeve_name, $sleeve_arr)) {
					$sleeve_arr[$sleeve_name] += $sleeve_number;
				}
				else {
					$sleeve_arr[$sleeve_name] = $sleeve_number;
				}
			}
		}
		?>

	  <div class="wrapper_cards">
	  	<ul>
	  		<?php
				foreach($sleeve_arr as $key => $sleeve) {
				?>
		  	<li>
			  	<div class="cards_size"><p><?php echo $key; ?> Sleeves</p></div>
			  	<div class="cards_number"><p><strong><?php echo $sleeve; ?></strong></p></div>
		  	</li>
			  <?php
				}
				?>
			</ul>
		</div>
		<?php
	}
}
?>