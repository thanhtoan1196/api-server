<?php

$video = $_GET['id'];
$title = $_GET['title'];
$typesub = $_GET['typesub'];
$sub = $_GET['sub'];
$cover = $_GET['cover'];
$efg = $_GET['efg'];
$rl = $_GET['rl'];
$vabr = $_GET['vabr'];
$oh = $_GET['oh'];
$oe = $_GET['oe'];
if($video == ''){
	echo "Where is the media ID?"; //https://openload.co/embed/7zLUwKrlQqCk  (The ID is "7zLUwKrlQqCk" in this case)
	exit();
}else{
	// $response = str_replace('https://', 'http://', $video);
	if (strpos($video, 'fbcdn') !== false) {
    	     echo $video . "&efg=" . $efg . "&rl=" . $rl . "&vabr=" . $vabr . "&oh=" . $oh . "&oe=" . $oe;
	} else {
	     echo $video . "&title=" . $title . "&typesub=" . $typesub . "&sub=" . $sub . "&cover=" . $cover;
	}
}
?>
