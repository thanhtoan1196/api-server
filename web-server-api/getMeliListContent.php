<?php

// ini_set('display_errors', 1);

require_once 'libraries/httpProxyClass.php';
require_once 'libraries/cloudflareClass.php';

$video = $_GET['id'];
mehlizmovies($video);

header("Content-type:application/json");
function apivn_curl($url, $body='') {

	$httpProxy   = new httpProxy();
	$httpProxyUA = 'proxyFactory';

	$requestLink = $url;
	$requestPage = json_decode($httpProxy->performRequest($requestLink));
	// if page is protected by cloudflare
	if($requestPage->status->http_code == 503) {
		// Make this the same user agent you use for other cURL requests in your app
		cloudflare::useUserAgent($httpProxyUA);

		// attempt to get clearance cookie
		if($clearanceCookie = cloudflare::bypass($requestLink)) {
			// use clearance cookie to bypass page
			$requestPage = $httpProxy->performRequest($requestLink, 'GET', null, array(
				'cookies' => $clearanceCookie
			));
			// return real page content for site
			$requestPage = json_decode($requestPage);
			// echo $requestPage->content;
			return $requestPage->content;
		} else {
			// could not fetch clearance cookie
			echo 'Could not fetch CloudFlare clearance cookie (most likely due to excessive requests)';
			return 'Could not fetch CloudFlare clearance cookie (most likely due to excessive requests)';
		}
	} else {
		$ch = @curl_init();
		$header[] = "accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
		$header[] = "accept-language:vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5,zh-CN;q=0.4,zh;q=0.3,mt;q=0.2,ar;q=0.1";
		$header[] = "cookie:__cfduid=d423e7ef4e95e5e89a05b50ee14ba96db1512536549; _ga=GA1.2.1317970125.1512536554; _gid=GA1.2.1780641636.1512536554; __tawkuuid=e::mehlizmovies.is::vYgHBG+g1fq34xEzEsDBT7m2vdrCBXUiXknpWP7uFhPNQchgnOI2ZAmtDct1ZJId::2; starstruck_15026280e0f5d74c7a1b427352d568f1=288515133d38abfdf46c674f082bfcbc; _gat=1; TawkConnectionTime=0; Tawk_58e9592cf7bbaa72709c52ac=vs23.tawk.to::0; sc_is_visitor_unique=rx11312455.1512537482.79C710E5FABD4F6BC52B47A32C441118.1.1.1.1.1.1.1.1.1-7124130.1512537478.1.1.1.1.1.1.1.1.1";
		$header[] = "referer:https://www.mehlizmovies.is/";
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
}

function mehlizmovies($curl){
	$get = apivn_curl($curl);
	echo $get;
}

?>