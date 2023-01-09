<?php
$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$message=$_POST['message'];
$to = $_POST['rcvEmail'];
$subject = $_POST['subject']. ' enquiry';
$body = 'Sender Name: '.$name.'<br/>';
$body .= 'Sender Email: '.$email.'<br/>';
if(!empty($phone)){
	$body .= 'Telephone: '.$phone.'<br/>';
}
$body .= 'Message: '.$message.'<br/>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
$headers .= 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message

//if "email" variable is filled out, send email
 if (isset($_REQUEST['rcvEmail']))  {
  //send email
  mail($to, $subject, $body, $headers);
  
  //Email response
  }
?>