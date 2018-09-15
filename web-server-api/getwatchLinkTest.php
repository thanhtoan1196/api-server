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
		if (strpos($video, 'load.php') !== false) {
			$title = str_replace(' ', '+', $title);
			$movie = $video . "&title=" . $title . "&typesub=" . $typesub . "&sub=" . $sub . "&cover=" . $cover;
			echo $movie;
			// getMovies($movie);
			// $xxx = urlencode($movie);
			// header("Location: $playerurl?movie=$xxx");
		} else {
			$title = str_replace(' ', '+', $title);
			$movie = $video . "&title=" . $title . "&typesub=" . $typesub . "&sub=" . $sub . "&cover=" . $cover;
			getMovies($movie);
		}
	} else {
		echo $video;
	}
}
header("Content-type:application/json");
function apivn_curl($url, $body='') {
	$ch = @curl_init();
	$header[] = "accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
	$header[] = "accept-language:vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5,zh-CN;q=0.4,zh;q=0.3,mt;q=0.2,ar;q=0.1";
	$header[] = "cookie:__cfduid=d3d781317e8aaa0188b43e092b2c0a3ef1534950163; _ga=GA1.2.1946866875.1534950335; __test; _gid=GA1.2.248072669.1537002700; _gat_gtag_UA_119520712_4=1";
	$header[] = "referer:https://ww5.gowatchseries.co/";
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
function getEmbedMovies($curl) {
	$basedomain = file_get_contents("https://domain.embed.is/"); 
	$get = apivn_curl($curl);
	$pieces = explode("//embed.is/result/?id=", $get);
	$data = explode("'", $pieces[1]);
	if(empty($data[0])) {
		echo "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4";
	} else {
		echo $basedomain . '/movie/stream.php?mid=' . $data[0];
	}
}
function getMovies($curl) {
	$get = apivn_curl($curl);
	$pieces = explode("file: '", $get);
	$data = explode("',label", $pieces[1]);
	if (strpos($data[0], 'fbcdn') !== false) {
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
		if (empty($link) != false) {
		    echo $data[0];
		} else {
			echo "http://linkdelivery46.micetop.us/cdn2_vidcdn_pro" . $link;
		}
	}
}
?>
