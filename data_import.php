<?php
include_once("login_session.php");
if (($handle = fopen(dir_path() . "/data/games_export_1.csv", "r")) !== FALSE) {
	$game_arr = array();
	// echo '10';
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $game_name = $data[0];
    $game_url = $data[1];
    $game_detail = $data[2];
    // $card_nb = array();
    $card_total = 0;
    // $sleeve_size = array();
    $sleeve_arr = array();

  	echo $data[0] . '<br>';
  	echo $data[1] . '<br>';
  	// echo $data[2] . '<br>';

		$game_data = explode("\n", $game_detail); 
		foreach($game_data as &$row) {

			if(strpos($row, "Number of cards:") !== false) {
				echo $row . '<br>';
				$card_total = $row;
				// array_push($card_nb, $row);
			}
			elseif(strpos($row, " sleeve size:") !== false) {

				$sleeve_detail = array(
					'card_total' => $card_total,
					'sleeve_brand' => $row,
					'sleeve_size' => $row
				);
				echo $row . '<br>';
				array_push($sleeve_arr, $sleeve_detail);
			}
			elseif(strpos($row, "Expansion") !== false || strpos($row, "----") !== false) {
				break;	
			}

		}

		$game_arr[] = array(
			'game_name' => $game_name,
			'game_url' => $game_url,
			// 'card_nb' => $card_nb,
			'sleeves' => $sleeve_arr,
		);
		$json_data = json_encode($game_arr);

  }
  fclose($handle);

	$json_data = json_encode($game_arr);
	file_put_contents(dir_path() . "/data/new.json",$json_data);
}
?>