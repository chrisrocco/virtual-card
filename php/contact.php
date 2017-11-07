<?php

    require __DIR__ . '/../vendor/autoload.php';

    use Mailgun\Mailgun;

    $config = require __DIR__ . '/config.php';

    $mg = Mailgun::create($config['api_key']);

    // Messages
    define('MSG_INVALID_NAME','Please enter your name.');
    define('MSG_INVALID_EMAIL','Please enter valid e-mail.');
    define('MSG_INVALID_MESSAGE','Please enter your message.');
    define('MSG_SEND_ERROR','Sorry, we can\'t send this message.');

	// Sender Info
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$message = trim($_POST['message']);
	$err = "";
	
	// Check Info
	$pattern = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$^";
	if(!preg_match_all($pattern, $email, $out)) {
		$err = MSG_INVALID_EMAIL; // Invalid email
	}
	if(!$email) {
		$err = MSG_INVALID_EMAIL; // No Email
	}	
	if(!$message) {
		$err = MSG_INVALID_MESSAGE; // No Message
	}
	if (!$name) {
		$err = MSG_INVALID_NAME; // No name 
	}

	if($err !== ""){
	    echo $err;
    } else {
        $mg->messages()->send($config['domain'], [
            'from'    => $email,
            'to'      => $config['to_email'],
            'subject' => $config['to_subject'],
            'text'    => $message
        ]);

        echo "SENT!";
    }
?>