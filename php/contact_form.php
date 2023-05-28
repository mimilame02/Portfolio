<?php
function outputAndDie($array) {
    echo json_encode($array);
    die();
}

if($_POST)
{
    // Check if all POST variables are set
    if(!isset($_POST["sender_name"], $_POST["sender_email"], $_POST["message_content"])){
        outputAndDie(array(
            'type' => 'error',
            'text' => 'POST variables are not set.'
        ));
    }

    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
    {
        outputAndDie(array(
            'type' => 'error',
            'text' => 'Sorry Request must be Ajax POST'
        ));
    }

    //Sanitize input data using PHP filter_var() or htmlspecialchars().
    $sender_name        = htmlspecialchars($_POST["sender_name"], ENT_QUOTES, 'UTF-8');
    $sender_email       = filter_var($_POST["sender_email"], FILTER_SANITIZE_EMAIL);
    $message_content    = htmlspecialchars($_POST["message_content"], ENT_QUOTES, 'UTF-8');

    //additional php validation
    if(strlen($message_content)<3) //check empty message
    {
        outputAndDie(array('type'=>'error_message_content', 'text' => 'Message content is too short.'));
    }
    if(strlen($sender_name)<3) // If length is less than 3 it will output JSON error.
    {
        outputAndDie(array('type'=>'error_sender_name', 'text' => 'Provided name is too short.'));
    }
    if(!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) //email validation
    {
        outputAndDie(array('type'=>'error_sender_email', 'text' => 'E-mail format is incorrect.'));
    }


	/*------------------------------------*\
		E-mail send
	\*------------------------------------*/

	//Recipient email, Replace with own email here
	$to_email = "mail@example.com";

	//email headers
	$headers  = "Content-type: text/html; charset=utf-8" . "\r\n";
	$headers .= "Reply-To: " . $sender_email . "\r\n";
	$headers .= "X-Mailer: PHP/" . phpversion();

	//email subject
	$message_subject = "You've got mail! From " . $sender_name . ".";

	//email content
	$message_body  = "<b>Sender:</b> \r\n <br>" . $sender_name . " &lt;" . $sender_email . "&gt;\r\n\r\n <br><br>";
	$message_body .= "<b>Message:</b> \r\n <br>" . $message_content;

	//send mail function
	$send_mail = mail($to_email, $message_subject, $message_body, $headers);


	/*------------------------------------*\
		E-mail status
	\*------------------------------------*/

	//If mail couldn't be sent output error. Check your PHP email configuration.
	if(!$send_mail)
	{
		$output = json_encode(array('type'=>'error', 'text' => 'There was an error while sending message.'));
		die($output);
	}
	else
	{
		$output = json_encode(array('type'=>'message', 'text' => 'Thanks for message, ' . $sender_name . '. <br> I will reply as fast as I can.'));
		die($output);
	}

}

?>
