<?php
$SONGS_FILE = "songs_shuffled.txt";

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

$top = "";

if (isset($_REQUEST["top"])) {
	$top = preg_replace("/[^0-9]*/", "", $_REQUEST["top"]);
}

if (!file_exists($SONGS_FILE)) {
	header("HTTP/1.1 500 Server Error");
	die("ERROR 500: Server error - Unable to read input file: $SONGS_FILE");
}

header("Content-type: application/json");

// print "{\n  \"songs\": [\n";

// // write a code to : 
// // 1. read the "songs.txt" (or "songs_shuffled.txt" for extra mark!)
// // 2. search all the songs that are under the given top rank 
// // 3. generate the result in JSON data format 
// $file = file($SONGS_FILE);
// $json = '';
// $tmp = array();
// for ($i = 0; $i < count($file); ++$i) {
// 	list($title, $artist, $rank, $genre, $time) = explode("|", trim($file[$i]));
// 	if ($rank <= $top) {
// 		$tmp[((int)$rank) - 1] = '{"title": "' . $title . '", "artist": "' . $artist . '", "rank": "' . $rank . '", "genre": "' . $genre . '", "time": "' . $time . '"},';
// 	}
// }

// for ($i = 0; $i < count($tmp); ++$i) {
// 	$json .= $tmp[$i];
// }
// $json = substr($json, 0, strlen($json) - 1);
// print $json;
// print "  ]\n}\n";

// Using json_encode ================================================

$file = file($SONGS_FILE);
$json = array();
$json["songs"] = array();
$tmp = array();
foreach($file as $line) {
	list($title, $artist, $rank, $genre, $time) = explode("|", trim($line));
	if ($rank <= $top) {
		$tmp[((int)$rank) - 1] = array(
			"title" => $title,
			"artist" => $artist,
			"rank" => $rank,
			"genre" => $genre,
			"time" => $time
			);
	}
}

for ($i = 0; $i < count($tmp); ++$i) {
	$json["songs"][] = $tmp[$i];
}
$json_dump = json_encode($json);
print $json_dump;
?>
