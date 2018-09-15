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
	$header[] = "cookie:__cfduid=d328ec335b4cf1923184c874ab307f4301529074326; _ga=GA1.2.1148281043.1529074418; __gads=ID=f725f9b7eada8da2:T=1534950160:S=ALNI_MbD-qJwdyfcKV6ZSCx9Pu_448xqKw; gogoanime=a1mk88v5k0sa5t1g67ie3bfm46; token=hDt%2F1Zh9tbbGazdHs9p5ao9GcQloT4Vt3FlvsV5VWa2NwfpFWjb3y5EnQZlKm6AlIS6pWAmbQrt3zxtTW%2FZpqw%3D%3D; _gid=GA1.2.1155025335.1537002669; BB_plg=pm; __test; bbl=6; MarketGidStorage=%7B%220%22%3A%7B%22svspr%22%3A%22%22%2C%22svsds%22%3A15%2C%22TejndEEDj%22%3A%22XqtiSVzSJ%22%7D%2C%22C160923%22%3A%7B%22page%22%3A4%2C%22time%22%3A1537002817824%7D%2C%22C264950%22%3A%7B%22page%22%3A3%2C%22time%22%3A1537002688653%7D%2C%22C242770%22%3A%7B%22page%22%3A5%2C%22time%22%3A1537002817939%7D%2C%22C267237%22%3A%7B%22page%22%3A3%2C%22time%22%3A1537002817583%7D%7D";
	$header[] = "referer:https://vidcloud.icu/";
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
