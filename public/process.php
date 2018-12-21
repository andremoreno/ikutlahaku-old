<?php

if($_POST) {

	$to_email = "admin@ikutlahaku.com"; //Recipient email, Replace with own email here
	$url = 'https://api.sendgrid.com/';
	$user = 'andremoreno'; // place SG username here
	$pass = 'CrufAzafr3'; // place SG password here

	//check if its an ajax request, exit if not
	//if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	if (!isset($_POST['msg']) && empty($_POST['msg'])) {
		$output = json_encode(array( //create JSON data
			'type'=>'error',
			'text' => 'Sorry Request must be POST'
		));
		die($output); //exit script outputting json data
	}

	//Sanitize input data using PHP filter_var().
	$user_name      = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
	$user_email     = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
	$phone_number   = filter_var($_POST["phone_number"], FILTER_SANITIZE_NUMBER_INT);
	$subject        = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
	$message        = filter_var($_POST["msg"], FILTER_SANITIZE_STRING);

	//additional php validation
	if(strlen($user_name)<4) { // If length is less than 4 it will output JSON error.
		$output = json_encode(array('type'=>'error', 'text' => 'Name is too short or empty!'));
		die($output);
	}

	if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){ //email validation
		$output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid email!'));
		die($output);
	}

	if(!filter_var($phone_number, FILTER_SANITIZE_NUMBER_FLOAT)){ //check for valid numbers in phone number field
		$output = json_encode(array('type'=>'error', 'text' => 'Enter only digits in phone number'));
		die($output);
	}

	if(strlen($subject)<3){ //check emtpy subject
		$output = json_encode(array('type'=>'error', 'text' => 'Subject is required'));
		die($output);
	}

	if(strlen($message)<3){ //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Too short message! Please enter something.'));
		die($output);
	}

	//email body
	//$message_body = $message."\r\n\r\n-".$user_name."\r\nEmail : ".$user_email."\r\nPhone Number : (".$country_code.") ". $phone_number;

	//proceed with PHP email.
	//$headers = 'From: '.$user_name.'' . "\r\n" .
    //'Reply-To: '.$user_email.'' . "\r\n" .
    //'X-Mailer: PHP/' . phpversion();

	//$send_mail = mail($to_email, $subject, $message_body, $headers);

	$params = array(
		'api_user'  => "$user",
		'api_key'   => "$pass",
		'to'        => "admin@ikutlahaku.com", // set TO address to have the contact form's email content sent to
		'subject'   => "Contact Form Submission", // Either give a subject for each submission, or set to $subject
		'html'      => "<html><head><title> Contact Form</title></head><body>
		Name: $user_name\n<br>
		Email: $user_email\n<br>
		Subject: $subject\n<br>
		Phone Number : $phone_number\n<br>
		Message: $message </body></html>", // Set HTML here.  Will still need to make sure to reference post data names
		'text'      => "
		Name: $user_name\n\n
		Email: $user_email\n\n
		Subject: $subject\n\n
		Phone Number : $phone_number\n\n
		Message:\n
		$message",
		'from'      => "admin@ikutlahaku.com", // set from address here, it can really be anything
	);

	$request =  $url.'api/mail.send.json';


	/*
	curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
	$request =  $url.'api/mail.send.json';
	// Generate curl request
	$session = curl_init($request);
	// Tell curl to use HTTP POST
	curl_setopt ($session, CURLOPT_POST, true);
	// Tell curl that this is the body of the POST
	curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
	// Tell curl not to return headers, but do return the response
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	// obtain response
	$response = curl_exec($session);
	curl_close($session);
	*/

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $request);
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
	//curl_setopt($ch, CURLOPT_VERBOSE, true);

	$response = curl_exec($ch);
	$response_info=curl_getinfo($ch);
	curl_close($ch);

	if ($response_info['http_code'] == 200) {
		$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_name .' Thank you for your email<br />'));
		die($output);
	} else {
		$output = json_encode(array('type'=>'error', 'text' => '<h3>Something Wrong!<br />Could not send mail!<br /></h3>'));
		die($output);
	}
}

?>