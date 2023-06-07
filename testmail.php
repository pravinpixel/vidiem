<?php
error_reporting(-1);

require_once 'phpmailer/PHPMailerAutoload.php';

function send_mail($tomail,$mlsubject,$bdymsg,$for,$storename)
{
    $to = 'durairaj.pixel@gmail.com';
	$subject=$mlsubject;
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->isHTML(true);
    $mail->Debugoutput = 'html';
   	$mail->Host = "smtp.office365.com";
	$mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth   = true;
	$mail->Username = "orders@vidiem.in";
	$mail->Password = "Fus32406";
	$mail->setFrom('orders@vidiem.in', 'Vidiem');
    $mail->FromName =$storename;
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->msgHTML($bdymsg);
    $mail->SMTPDebug=3;
    $mail->Debugoutput = 'html';
    
   
 
    if (!$mail->send()) {
       $error = "Mailer Error: " . $mail->ErrorInfo;
      echo $error; exit;

    } 
    else {
		echo "sucess";

    }

	
}

 echo send_mail('pravin@pixel-studios.com','SMTP Mail function','Test mail content','1','Vidiem');

 
?>