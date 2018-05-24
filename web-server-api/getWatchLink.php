<?php

$video = $_GET['id'];
$title = $_GET['title'];
$typesub = $_GET['typesub'];
$sub = $_GET['sub'];
$cover = $_GET['cover'];
if($video == ''){
	echo "Where is the media ID?"; //https://openload.co/embed/7zLUwKrlQqCk  (The ID is "7zLUwKrlQqCk" in this case)
	exit();
}else{
	// $response = str_replace('https://', 'http://', $video);
	echo $video . "&title=" . $title . "&typesub=" . $typesub . "&sub=" . $sub . "&cover=" . $cover;
}
?>
