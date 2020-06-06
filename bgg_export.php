<?php
// Do a daily export from the BGG Geeklist and export it to a file
// Handy to revert back to old versions of data

// https://www.phpjabbers.com/measuring-php-page-load-time-php17.html
// Timing
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;


$bgg_list_id = 164572;
// $bgg_list_id = 272582; // Smaller list

$uri = 'https://www.boardgamegeek.com/xmlapi/geeklist/' . $bgg_list_id;

$response = file_get_contents($uri);
$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);

$json = json_encode($xml);

$filePath = realpath(dirname(__FILE__));
$rootPath = realpath($_SERVER['DOCUMENT_ROOT']);
$htmlPath = str_replace($rootPath, '', $filePath);

$file = $htmlPath . '/data/export.txt';
echo $file;

$open = fopen( $file, "w" ); 
$write = fputs( $open, $json ); 
fclose( $open );
$array = json_decode($json,TRUE);

// Timing
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

echo 'File exported after ' . $total_time . ' seconds.';