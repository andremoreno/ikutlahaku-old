<?php

function __proxyChecker($proxy) {
	$url = "http://www.smsgratis.web.id";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.smsgratis.web.id');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; rv:39.0) Gecko/20100101 Firefox/39.0');
	//curl_setopt($ch, CURLOPT_NOBODY, true);
	$handle = curl_exec($ch);
	$response_info=curl_getinfo($ch);
	curl_close($ch);
	if ($response_info['http_code'] == 200) {
		return true;
	} else {
		return false;
	}
}

$timeout = "15";
//http://www.xroxy.com/proxylist.php?port=&type=Anonymous&ssl=ssl&country=US&latency=1000
//$url = "http://www.xroxy.com/proxylist.php?port=8080&type=All_http&ssl=ssl&country=&latency=1000&reliability=9000&sort=latency#table";

$url = "http://www.xroxy.com/proxylist.php?type=All_http&ssl=&country=US&latency=1000&reliability=9000&sort=latency";

//$url = "http://www.xroxy.com/proxylist.php?port=&type=Anonymous&ssl=ssl&country=&latency=1000&reliability=9000#table";

$cache = 'proxylist.txt';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($curl);
curl_close($curl);
//return $page;
//$page = curl_func($url);

preg_match_all('/&host=((?:[0-9]{1,3}\.){3}[0-9]{1,3})&port=(\d+)/', $page, $matches, PREG_SET_ORDER);

// Check if the proxy is accepting connections and if so, add it to the list

foreach($matches as $row) {
	$proxy = $row[1].":".$row[2];
	$proxy = trim($proxy);
	if(__proxyChecker($row[1].":".$row[2])) {
		//if ($fp = @fsockopen($row[1], $row[2], $errno, $errstr, 5)) {
		//fclose($fp);
		$text .= "{$row[1]}:{$row[2]}\n";
		break;
	}
}

file_put_contents($cache, $text);
echo "Proxy Found!";
//print_r(count($matches));
//exit;

?>