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
$playerurl = "embed.html";
if($video == '') {
	echo "Where is the media ID?"; //https://openload.co/embed/7zLUwKrlQqCk  (The ID is "7zLUwKrlQqCk" in this case)
	exit();
} else {
	// $response = str_replace('https://', 'http://', $video);
	if (strpos($video, 'fbcdn') !== false) {
		echo $video . "&efg=" . $efg . "&rl=" . $rl . "&vabr=" . $vabr . "&oh=" . $oh . "&oe=" . $oe;
	} else if (strpos($video, 'vidnode.net') !== false || strpos($video, 'vidcloud.icu') !== false) {
		if (strpos($video, 'http://') !== false) {
			$video = str_replace('http://', 'https://', $video);
		}
		if (strpos($video, 'load.php') !== false) {
			$title = str_replace(' ', '+', $title);
			$movie = $video . "&title=" . $title . "&typesub=" . $typesub . "&sub=" . $sub . "&cover=" . $cover;
// 			$movie = str_replace('load.php', 'streaming.php', $movie);
			echo $movie;
		} else {
			$title = str_replace(' ', '+', $title);
			$movie = $video . "&title=" . $title . "&typesub=" . $typesub . "&sub=" . $sub . "&cover=" . $cover;
			getMovies($movie);
		}
	} else {
		if (strpos($video, 'https://www.rapidvideo.com/e/') !== false) {
			$video = str_replace('https://www.rapidvideo.com/e/', 'https://www.rapidvideo.com/d/', $video);
			$video = $video . "----------" . "a-9-href-mp4|a-10-href-mp4|a-11-href-mp4";
		}
		echo $video;
	}
}
header("Content-type:application/json");
function apivn_curl($url, $body='') {
	$ch = @curl_init();
	$header[] = "accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
	$header[] = "accept-language:vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5,zh-CN;q=0.4,zh;q=0.3,mt;q=0.2,ar;q=0.1";
	$header[] = "cookie:NID=132=zL1q2-YwKpCwyro9VtPSK7uENnv0-yQi80jCkoCg2TlgYl85gZLY40vhKkNWP6EhAZYjbpR6K0y9ocMSDHTTCfbaXnSRiv98PUh8cjrJ_MoeYPnZMwjE7TBqHxFMNDxR; __cfduid=d44b2e032b3c8a2ffd8ad97e873f43b771527127691; _ga=GA1.2.552850278.1527127692; _gid=GA1.2.429859876.1529310209; token=5b276ebc7f17c; tvshow=e6e6c51hv9jveu4ea75pc7l8q7";
	$header[] = "referer:https://vidnode.net/";
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	if($body)	curl_setopt($ch, CURLOPT_POST, true); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if($body)	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	curl_setopt($ch, CURLOPT_ENCODING , 'gzip, deflate');
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
header("Content-type:application/json");
function apivn_curl_ol($url, $body='') {
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	if($body)	curl_setopt($ch, CURLOPT_POST, true); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if($body)	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	curl_setopt($ch, CURLOPT_ENCODING , 'gzip, deflate');
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
function getMovies($curl) {
	$get = apivn_curl($curl);
	$pieces = explode("file: '", $get);
	$data = explode("',label", $pieces[1]);
	if (strpos($data[0], 'googleusercontent') !== false) {
		echo $data[0];
	} else {
		$arr = explode("/", $data[0]);
		$link = "";
		foreach ($arr as $key => $value) {
		    if ($key >= 7) {
		    	$link = $link . "/" . $value;
		    }
		    // echo $arr;
		}
		
// 		if (empty($link) != false) {
			if (empty($data[0]) || strpos($data[0], 'googleusercontent') == false) {
				$piecesOL = explode("openload.co/embed/", $get);
				$dataOL = explode("Openload", $piecesOL[1]);
				$openloadURL = substr($dataOL[0], 0, strlen($dataOL) - 2);
                
				// get rapid direct video
				// $piecesRapidDL = explode("rapidvideo.com/e/", $get);
				// $dataRapidDL = explode(">", $piecesRapidDL[1]);
				// $downloadRapidURL = substr($dataRapidDL[0], 0, strlen($dataRapidDL[0]) - 1);
				// $getRapidDL = apivn_curl_ol("https://www.rapidvideo.com/d/" . $downloadRapidURL);
				// $piecesRapidDLD = explode("button-download", $getRapidDL);
				// $dataRapidDLD_1 = explode("<a href=", $piecesRapidDLD[0]);
				// $dataRapidDLD_2 = substr($dataRapidDLD_1[count($dataRapidDLD_1)  - 1], 1, strlen($dataRapidDLD_1) - 6);
				// if (!empty($dataRapidDLD_2) && strpos($dataRapidDLD_2, 'mp4') !== false) {
				// 	echo $dataRapidDLD_2;
				// } else {
					// get vidcloud direct video
				// 	$piecesDL = explode("window.open(", $get);
				// 	$dataDL = explode(",", $piecesDL[1]);
				// 	$dataTrim = trim($dataDL[0]);
				// 	$downloadURL = substr($dataTrim, 1, strlen($dataTrim) - 2);
				// 	$getDL = apivn_curl_ol($downloadURL);
				// 	$piecesDLD = explode("href=", $getDL);
				// 	$dataDLD_1 = explode("download", $piecesDLD[4]);
				// 	$dataDLD_2 = substr($dataDLD_1[0], 1, strlen($dataDLD_1) - 2);
				// 	$dataDLD_2 = str_replace(' ', '%20', $dataDLD_2);
				// 	$dataDLD_2 = str_replace('amp;', '', $dataDLD_2);
				// 	if (!empty($dataDLD_2) && strpos($dataDLD_2, 'mp4') !== false) {
				// 		echo $dataDLD_2;
				// 	} else {
						$getOL = apivn_curl_ol("https://getlinkaz.com/get/API/?api=Vankhoa01&id=Fb-openload&link=https://openload.co/f/" . $openloadURL);
						if (empty($getOL[0])) {
							echo "https://thisisnotalink.mp4"; //echo $curl;
						} else {
							echo $getOL;
						}
				// 	}
				// }
			
			} else {
				echo "$data[0]";
			}
// 		} else {
// 			echo $curl;
// 		}
	}
}
?>
