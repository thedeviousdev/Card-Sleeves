<?php
if (($handle = fopen("data/run_results.csv", "r")) !== FALSE) {
	$game_arr = array();
	echo '10';
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $game_name = $data[0];
    $game_url = $data[1];
    $game_detail = $data[2];
    $card_nb = array();
    $sleeve_size = array();
  	// echo $data[0] . '<br>';
  	// echo $data[1] . '<br>';

		$game_data = explode("\n", $game_detail); 
		foreach($game_data as &$row) {

			if(strpos($row, "Number of cards:") !== false) {
				// echo $row . '<br>';
				array_push($card_nb, $row);
			}
			elseif(strpos($row, "Mayday sleeve size:") !== false) {
				// echo $row . '<br>';
				array_push($sleeve_size, $row);			
			}
			elseif(strpos($row, "Expansion") !== false) {
				break;	
			}

		}

		$game_arr[] = array(
			'game_name' => $game_name,
			'game_url' => $game_url,
			'card_nb' => $card_nb,
			'sleeve_size' => $sleeve_size,
		);
		$json_data = json_encode($game_arr);

  }
  fclose($handle);

	$json_data = json_encode($game_arr);
	file_put_contents("data/new.json",$json_data);
}
?>