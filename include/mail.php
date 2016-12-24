<?php
require 'PHPMailer-master/PHPMailerAutoload.php';
global $mail_error;
function smtpmailer($to, $from, $from_name, $subject, $body,$mess){
$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->SMTPDebug = 0; 
$mail->SMTPAuth = true;  
$mail->SMTPSecure = 'tls'; 
$mail->Host = 'smtp.live.com';
$mail->Port = 587; 
$mail->Username = $from;  
$mail->Password = 'QwertY78';           
$mail->SetFrom($from, $from_name);
$mail->Subject = $subject;
    $mail->IsHTML(True);
    $mail->Body=$body;
$mail->AddAddress($to);
if(!$mail->Send()) {
	$mail_error=false;
    $mess = 'Mail error: '.$mail->ErrorInfo; 
    return $mess;

} else {
    $mail_error=true;
    return $mess;
}

}
//$to='feedback-discuss@outlook.com';
//$subject='feedback';

?>