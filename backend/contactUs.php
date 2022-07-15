<?php
header('Content-Type: application/json; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/libs/PHPMailer/src/Exception.php';
require __DIR__ . '/libs/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/libs/PHPMailer/src/SMTP.php';

if (!isset($_POST['name']) && !isset($_POST['email'])) {
  echo json_encode(['status' => false, 'message' => 'Bad Request']);
  http_response_code(400);
  die();
}

$mail = new PHPMailer(true);
try {
  //Server settings
  $mail->SMTPDebug = 1;  //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
  $mail->SMTPAuth = true;                                   //Enable SMTP authentication
  $mail->Username = 'romanyaremenkotest@gmail.com';                     //SMTP username
  $mail->Password = 'iiezixnyqethkphn';                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
  $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
//  $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  //Recipients
  $mail->setFrom('romanyaremenkotest@gmail.com', 'Contact Us');
  $mail->addAddress("romanyaremenkotest@gmail.com", "info");      //Add a recipient
//  $mail->addReplyTo('info@example.com', 'Information');
//  $mail->addCC('cc@example.com');
//  $mail->addBCC('bcc@example.com');

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Contact Us';
  $body = "Name: {$_POST['name']} \n Phone: {$_POST['phone']} \n gender: {$_POST['gender']} \n birthday: {$_POST['birthday']} \n allergy: {$_POST['allergy']}";
  $altBody = str_replace(PHP_EOL, '<br>', $body);
  $mail->Body = $altBody;
  $mail->AltBody = $altBody;

  $mail->send();
} catch (Exception $e) {
  echo json_encode(['status' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
  http_response_code(400);
  die();
}

echo json_encode(['status' => true, 'message' => '']);
http_response_code(200);
die();
