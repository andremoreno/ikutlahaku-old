<?php

error_reporting(0);
session_start();


$apiKey = "668c1ca6c5f455da8ee7b141e81999f0d65a5821";

//^08[0-9]{9,}$

require 'class-Clockwork.php';


if (isset($_POST) && !empty($_POST)) {
	if ($_POST["formid"] == $_SESSION["formid"]) {

		      

	if (isset($_POST['nomor']) && !empty($_POST['nomor'])) {
		$nomor = "62".$_POST['nomor'];
	} else {
		echo "Anda lupa memasukkan nomor tujuan.";
		exit;
	}



	if (isset($_POST['pesan'])) {
		$message = $_POST['pesan'];
	} else {
		$message = "Renungan Harian Ikutlah Aku - https://www.ikutlahaku.com";
	}

	if (strpos($_POST['pesan'], 'https://www.ikutlahaku.com') === false) {
		$message = "Renungan Harian Ikutlah Aku - https://www.ikutlahaku.com";
	}


	try
		{
		// Create a Clockwork object using your API key
		$clockwork = new Clockwork( $apiKey );

		// Setup and send a message
		$message = array( 'to' => $nomor, 'message' => $message );
		
		$result = $clockwork->send( $message );

		// Check if the send was successful

		if ($result['success']) {
			echo "SMS siap dikirim!<br />Anda bisa menutup halaman ini<br /><br /><br /><br />";
			echo 'ID: ' . $result['id'];
			$_SESSION["formid"] = '';
			exit;
		} else {
			echo "SMS gagal terkirim.<br /><br /><br /><br />";
			echo 'Error: ' . $result['error_message'];
		}
	}

	catch (ClockworkException $e) {
		echo 'Exception sending SMS: ' . $e->getMessage();
	}
	} else {

		echo "Silahkan tutup halaman ini";
		exit;
	}
} else {
	$_SESSION["formid"] = md5(rand(0,10000000));
	//$randcode = getrandcode();
	$content .= '<form method="post" enctype="multipart-form-data" action="index.php">';
	$content .= '<div>Nomor Ponsel:<br />+62<input type="text" maxlength="20" name="nomor" /><br />Pengirim:<br /><input type="text" maxlength="20" name="pengirim" /><br /><input type="submit" value="Send" />';
	//$content .= '<br /><br /><small>Note:<br />Saat ini sms bisa terkirim ke nomor Indosat dan Telkomsel.<br />Pergunakan dengan bijak.<br />Bila anda ingin mengirim ke teman anda, jangan lupa untuk memasukan nama anda.<br />Terkadang, diperlukan waktu 5-10 menit agar sms terkirim ke nomor penerima</small>';
	if (isset($_GET['text']) && !empty($_GET['text'])) {
		$content .= '<input type=hidden name=pesan value="'.$_GET['text'].'">';
	}
	//$content .= '<input type=hidden name=randcode value='.$randcode.'>';
	$content .= '<input type="hidden" name="formid" value="'.$_SESSION["formid"].'" />';
	$content .= '</div></form>';
	//$content .= "<!-- $cproxy -->";
	//$content .= js_counter("message","160");
	//theme('page', 'Free SMS', $content);
	echo $content;
	exit;
}







?>