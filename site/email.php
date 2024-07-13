<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include autoload.php (generat de Composer sau descarcat manual)
//require 'vendor/autoload.php';  // Dacă ai instalat prin Composer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function send_email($sender_email, $sender_password, $recipient_email, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Setari server
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Serverul SMTP al Gmail
        $mail->SMTPAuth = true;
        $mail->Username = $sender_email;  // Adresa ta de email
        $mail->Password = $sender_password;  // Parola ta de email
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Setari email
        $mail->setFrom($sender_email, 'Sorin Raducan');
        $mail->addAddress($recipient_email);  // Adresa destinatarului
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Trimitere email
        $mail->send();
        echo 'Email trimis cu succes!';
    } catch (Exception $e) {
        echo "Eroare: {$mail->ErrorInfo}";
    }
}


    $sender_email ="";
    $sender_password = "";
    $recipient_email = "";
    $subject = "";
    $body = "";

    send_email($sender_email, $sender_password, $recipient_email, $subject, $body);

?>