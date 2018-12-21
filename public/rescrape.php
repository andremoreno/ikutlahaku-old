<?php

$rss = new DOMDocument();
$rss->load('https://www.ikutlahaku.com/feed.xml');
$feed = array();

foreach ($rss->getElementsByTagName('item') as $node) {
    $item = array (
        'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
    );
    array_push($feed, $item);
}

$limit = 1;

for($x=0;$x<$limit;$x++) {
	$url = $feed[$x]['link'];
}

$fburl = "https://graph.facebook.com/?id=".$url."&scrape=true";

$ch = curl_init();
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_URL, $fburl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$user_agent = "Mozilla/5.0 (Windows NT 10.0; rv:50.0) Gecko/20100101 Firefox/50.0";
//$user_agent = "Mozilla/5.0 (Windows NT 6.1; rv:18.0) Gecko/20100101 Firefox/18.0";
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
$rawData = curl_exec($ch);
$response_info=curl_getinfo($ch);
curl_close($ch);


$decoded = json_decode($rawData,true);

print_r($decoded['og_object']['title']);exit;

?>