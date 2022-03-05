<?php
// ---------------------------------------------------------------------------------------------------------------
/*##########Script Information#########
  # Purpose: Send mail Using PHPMailer#
  #          & Gmail SMTP Server 	  #
  # Created: 24-11-2019 			  #
  #	Author : Hafiz Haider			  #
  # Version: 1.0					  #
  # Website: www.BroExperts.com 	  #
  #####################################

Include required PHPMailer files 

	require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';
//Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
//Create instance of PHPMailer
	$mail = new PHPMailer();
//Set mailer to use smtp
	$mail->isSMTP();
//Define smtp host
	$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
	$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
//Port to connect smtp
	$mail->Port = "587";
//Set gmail username
	$mail->Username = "wherearetheyare@gmail.com";
//Set gmail password
	$mail->Password = "";
//Email subject
	$mail->Subject = "Click this link to forgot password";
//Set sender email
	$mail->setFrom($email);
//Enable HTML
	$mail->isHTML(true);
//Attachment
	$mail->addAttachment('img/video.3gp');
	//Add recipient
	$mail->addAddress($email);
//Email body
	if($accountType =="admin"){
		$mail->Body = "Please click on the link below to forgot password:<br><br>
        	<a href='http://localhost/phpprograming/thesisA/admin/resetpassword.php?id=$email&token=$token'>Click Here</a>
		";
	}
	else if($accountType == "user"){
		$mail->Body = "Hello $userFirstName
 
		We've received your request to reset your Gnance password.
		
		Click <a href='http://localhost/phpprograming/thesisA/user/resetpassword.php?id=$email&token=$token'>Here</a> 
		to set a new password for your account.
		If you did not initiate this request, please contact our Customer Service Team immediately here.
		Cheers,
		Yahoonest Team<br><br>
		";
	}

//Finally send email
	if ( $mail->send() ) {
		//echo "Email Sent..!";
	}else{
		//echo "Message could not be sent";
		//echo "Message could not be sent. Mailer Error: "{$mail->ErrorInfo};
	}
//Closing smtp connection
	$mail->smtpClose();

*/
// ------------------------------------------------------- FOR webhosting ------------------------------------
ini_set("sealinescatering.com",1);
error_reporting(E_ALL);
// $from = "wherearetheyare@gmail.com";
// $to = "wherearetheyare@gmail.com";
// $subject="PHP MAIL SENDING Checking";
// $message = "yahoo";
// $headers = "From:".$from;
// mail($to,$subject,$message,$headers);
// echo "The email message was successfully sent.";
/*
https://stackoverflow.com/questions/11238953/send-html-in-email-via-php
https://www.tutorialrepublic.com/php-tutorial/php-send-email.php
*/
$to = $email;
$subject = 'Reset Password';
$from = 'sealinescatering.com';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
	'Reply-To: '.$from."\r\n" .
	'X-Mailer: PHP/' . phpversion();

if($accountType =="user"){
	// Compose a simple HTML email message
	$message = '<html><body>';
	$message .= "
	Hello $userDisplayName

		We've received your request to reset your Social Online password.
		
		Click <a href='http://sealinescatering.com/socialonline/resetpassword.php?id=$email&token=$token'>Here</a> 
		to set a new password for your account.
		If you did not initiate this request, please contact our Customer Service Team immediately here.
		Cheers,
		Social Online Team<br><br>
	";
	$message .= '</body></html>';
}
// Sending email
if(mail($to, $subject, $message, $headers)){
	// echo 'Your mail has been sent successfully.';
} else{
	// echo 'Unable to send email. Please try again.';
}