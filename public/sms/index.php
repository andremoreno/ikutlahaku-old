<?php
//error_reporting(0);
session_start();
require_once("global.php");

$useragent = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.18";

$proxyfile = "proxylist.txt";
$f = fopen($proxyfile, 'r');
$line = fgets($f);
fclose($f);

if (!empty($line)) {
	$cproxy = preg_replace("/\r|\n/","",$line);
} else {
	get_proxy();
	//$cproxy = '176.31.99.80:2222';
}



showHead();


if (isset($_POST) && !empty($_POST)) {
	if ($_POST["formid"] == $_SESSION["formid"]) {

	if (isset($_POST['nomor']) && !empty($_POST['nomor'])) {
		$nomor = $_POST['nomor'];
	} else {
		echo "Anda lupa memasukkan nomor tujuan.";
		exit;
	}
	
	//$randcode = $_POST['randcode'];

	if (isset($_POST['pengirim']) && !empty($_POST['pengirim'])) {
		$pengirim = " Pengirim: ".$_POST['pengirim'];
	}

	if (isset($_POST['pesan'])) {
		$message = $_POST['pesan'];
	} else {
		$message = "Renungan Harian Ikutlah Aku - https://www.ikutlahaku.com";
	}

	if (strpos($_POST['pesan'], 'https://www.ikutlahaku.com') === false) {
		$message = "Renungan Harian Ikutlah Aku - https://www.ikutlahaku.com";
	}

	$randcode = getrandcode();

	$post_items[] = "teks=".$pengirim;
	//$post_items[] = "randcode=".$randcode;
	$post_items[] = "Phonenumbers=".$nomor;
	$post_items[] = "Text=".$message;
	$post_items[] = "TOMBOL=KIRIM";
	$isipost = implode ('&', $post_items);
	//$useragent = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.18";
			
	//print_r($isipost);
	//exit;
	$mfip = rand(41, 238).'.'.rand(0, 254).'.'.rand(0, 254).'.'.rand(0, 254);

	//$ch = curl_init('http://sms-online.web.id/widget/kirim-sms.php');
	//$ch = curl_init('http://www.smsgratis.web.id/index.php?d=wg3&f=sms');
	$ch = curl_init('http://www.smsgratis.web.id/wg3/sms.php');
	curl_setopt($ch, CURLOPT_PROXY, $cproxy);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $isipost);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $mfip", "HTTP_X_FORWARDED_FOR: $mfip"));
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close ($ch);
	//print_r($output);exit;
	$output = explode ('<font color=blue>', $output);
	$output = explode ('</font><br><br>', $output[1]);
	if (stristr($output[0], 'siap dikirim')) {
		echo "SMS siap dikirim!<br />Anda bisa menutup halaman ini.";
	} else if (strpos($output, 'maaf sedang maintaiance server') !== false) {
		echo "Maaf, server sedang maintenance.<br />Silahkan mencoba beberapa saat lagi.";
	} else {
		echo "SMS gagal terkirim.<br /><a href=\"sms.php\">Klik disini untuk kembali mengirim SMS</a>";
		
	}
	$_SESSION["formid"] = '';
	} else {
		echo "Refresh detected.<br />Silahkan tutup halaman ini.";
	}
} else {
	$_SESSION["formid"] = md5(rand(0,10000000));	
	//$content .= '<form method="post" enctype="multipart-form-data" action="sms.php">';
	showForm();

}


showFoot();

?>