<?php

$video = $_GET['id'];
if($video == ''){
	echo "Where is the media ID?"; //https://openload.co/embed/7zLUwKrlQqCk  (The ID is "7zLUwKrlQqCk" in this case)
	exit();
}else{
	$response = str_replace('https://files.azmovies.co/', 'https://files.azmovies.co/files/', $video);;
	echo $response;
}
?>