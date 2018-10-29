<?php
include_once("login_session.php");

$string = file_get_contents("data/bgg_list.json");
$json = json_decode($string, true);

$file = 'data/games_db.sqlite';
if (file_exists($file)) {

	try {
	  $db = new PDO('sqlite:data/games_db.sqlite');


		$result = $db->query("SELECT * FROM Game WHERE Image = '0'");
		$id_string = '';
	  foreach($result as $row) {
	  	$id = $row['BGGID'];
	  	$id_string .= $id . ',';
	  }
  	bgg_search($id_string);
	}
	catch(PDOException $e) 	{
	  print 'Exception : '. $e->getMessage();
	}

}

function bgg_search($id){
	$uri = 'https://www.boardgamegeek.com/xmlapi2/thing?id='  . $id;
	echo $id;
	$response = file_get_contents($uri);
	$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	// echo '<pre>';
	// print_r($array);
	// echo '</pre>';
	echo 'bgg_search <br/>';

	foreach ($array['item'] as $game) {
		$thumbnail = $game['thumbnail'];

		if (array_key_exists(0, $game['name']))
			$name = $game['name'][0]['@attributes']['value'];
		else
			$name = $game['name']['@attributes']['value'];
		$game_id = $game['@attributes']['id'];
		$year = $game['yearpublished']['@attributes']['value'];

		echo $name . '<br/>';
		echo $game_id . '<br/>';
		echo $year . '<br/>';
		echo $thumbnail . '<br/>';
		update_game($game_id, $name, $year, $thumbnail);
	}
}

function update_game($bgg, $name, $year, $image) {
	echo 'update_game <br>';
	$image_path = download_image($name, $image, $year);
	echo 'image_path: ' . $image_path . '<br/>';
	echo 'UPDATE Game SET Year = "' . $year . '", Image = "' . $image_path . '" WHERE BGGID = "' . $bgg . '";';
	if($image_path != false) {
		try {
			$db = new PDO('sqlite:data/games_db.sqlite');

			$db->exec('UPDATE Game SET Year = "' . $year . '", Image = "' . $image_path . '" WHERE BGGID = "' . $bgg . '";');
		}
		catch(PDOException $e) 	{
		  print 'Exception : '. $e->getMessage();
		}
	}
}

function download_image($name, $image_url, $year){

	$extension = pathinfo($image_url, PATHINFO_EXTENSION);
	$clean_name = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $name));

	$path = $clean_name . $year . "." . $extension;

	echo 'download_image: ' . $path . '<br/>';
	if (!file_exists($path)) {
		$download = file_get_contents($image_url);

		if($download === false){
			return false;
		}
		else {
		  file_put_contents('img/' . $path, $download);
		  return $path;
		}
	}
	else {
		return $path;
	}
}
?>