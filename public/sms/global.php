<?php

function showHead() {
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Share via SMS</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!--[if lt IE 9]>
<script src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
.form-signin{max-width:330px;padding:15px;margin:0 auto}.form-signin .form-signin-heading,.form-signin .checkbox{margin-bottom:10px}.form-signin .checkbox{font-weight:normal}.form-signin .form-control{position:relative;height:auto;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:10px;font-size:16px}.form-signin .form-control:focus{z-index:2}.form-signin input[type="email"]{margin-bottom:-1px;border-bottom-right-radius:0;border-bottom-left-radius:0}.form-signin input[type="password"]{margin-bottom:10px;border-top-left-radius:0;border-top-right-radius:0}
</style>
</head>
<body>
<div class="container">
<form class="form-signin" method="post" enctype="multipart-form-data">
<h2 class="form-signin-heading">Share Via SMS</h2>
<?php
}

function showFoot() {
	echo '</form></div></Body></html>';
}

function showForm() {
echo '<div class="form-group">
<label for="nomor">Nomor Ponsel:</label>
<input type="tel" class="form-control" required placeholder="Nomor HP Tujuan" name="nomor" />
<p class="small help-block">Untuk saat ini, sms hanya bisa terkirim ke nomor Indosat dan Telkomsel. Contoh: 08561111111</p>
</div>
	
<div class="form-group">
<label for="pengirim">Pengirim</label>
<input type="text" class="form-control" placeholder="Nama Pengirim" name="pengirim" />
<p class="small help-block">Bila anda ingin mengirim ke teman anda, jangan lupa untuk memasukan nama anda.</p>
</div>

<div class="form-group">
<p class="small text-info">Terkadang, diperlukan waktu 5-10 menit agar sms terkirim ke nomor penerima</p>
</div>';
if (isset($_GET['text']) && !empty($_GET['text'])) {
	echo "<input type=hidden name=pesan value=\"".$_GET["text"]."\" />";
}
echo '<input type="hidden" name="formid" value="'.$_SESSION["formid"].'" />';
//echo '<button type="submit" class="btn btn-default" disabled="disabled">Kirim</button>';
echo '<button type="submit" class="btn btn-default">Kirim</button>';
}

function str_replace_first($from, $to, $subject) {
	$from = '/'.preg_quote($from, '/').'/';
	return preg_replace($from, $to, $subject, 1);
}

function getrandcode() {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_URL, "http://smsgratis.web.id/wg3/");
	curl_setopt($ch, CURLOPT_PROXY, $cproxy);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	//$user_agent = "Mozilla/5.0 (compatible; Snaptwit; " . BASE_URL . ") Gecko/20100101 Firefox/34.0";
	//$user_agent = "Mozilla/5.0 (Windows NT 6.1; rv:18.0) Gecko/20100101 Firefox/18.0";
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; rv:39.0) Gecko/20100101 Firefox/39.0');
	$rawData = curl_exec($ch);
	$response_info=curl_getinfo($ch);
	curl_close($ch);

	//print_r($rawData);
	$rawData = explode ('<input type=hidden name=randcode value=', $rawData);
	$rawData = explode ('><input type=hidden name=teks value=>', $rawData[1]);

	return $rawData[0];
}


function __proxyChecker($proxy) {
	$url = "http://smsgratis.web.id/wg3/";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_REFERER, 'http://smsgratis.web.id/wg3/');
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

function get_proxy() {
	$timeout = "15";
	//http://www.xroxy.com/proxylist.php?port=&type=Anonymous&ssl=ssl&country=US&latency=1000
	//$url = "http://www.xroxy.com/proxylist.php?port=8080&type=All_http&ssl=ssl&country=&latency=1000&reliability=9000&sort=latency#table";

	$url = "http://www.xroxy.com/proxylist.php?type=All_http&ssl=ssl&country=US&latency=1000&reliability=9000&sort=latency";

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
	//print_r(count($matches));
	//exit;
}


/*function sendSMS($post_data) {
	foreach ( $post_data as $key => $value) {
		$post_items[] = $key . '=' . $value;
	}
	$isipost = implode ('&', $post_items);

	$useragent = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16";

	#print_r($post_string);
	#exit;

	$ch = curl_init('http://sms-online.web.id/widget/sms.php');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $isipost);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close ($ch);
	$output = explode ('<font color=blue>', $output);
	$output = explode ('</font><br><br>', $output[1]);
	print_r($output[0]);
	#print_r($output);
}
*/
// -> <font color=blue>sms ke +6287887389457 siap dikirim</font><br><br><a href=index.php?teks=>Klik SINI untuk kirim SMS lagi</a><p>Lihat Balasan dari 087887389457 <br />klik <a href=inbox.php?hp=087887389457>INBOX</a><br>


#if (isset($_POST) && !empty($_POST)) {
#	//Send SMS through curl
#	$output = sendSMS($_POST);
#}

?>