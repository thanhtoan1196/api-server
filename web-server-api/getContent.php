<?php

$video = $_GET['id'];
if($video == ''){
	echo "Where is the media ID?"; //https://openload.co/embed/7zLUwKrlQqCk  (The ID is "7zLUwKrlQqCk" in this case)
	exit();
}else{
	$response = exec('./phantomjs getContent.js "'.$video.'"');
	echo $response;
}
?>