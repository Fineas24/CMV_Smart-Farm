<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'vendor/autoload.php';  // Assuming you have installed the league/oauth2-google package via Composer

function get_oauth_token($clientId, $clientSecret, $refreshToken) {
    $provider = new Google([
        'clientId'     => $clientId,
        'clientSecret' => $clientSecret,
    ]);

    $grant = new \League\OAuth2\Client\Grant\RefreshToken();
    $token = $provider->getAccessToken($grant, ['refresh_token' => $refreshToken]);

    return $token->getToken();
}

function send_email($clientId, $clientSecret, $refreshToken, $recipient_email, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Set up OAuth
        $oauthToken = get_oauth_token($clientId, $clientSecret, $refreshToken);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->AuthType = 'XOAUTH2';

        $mail->oauthUserEmail = $sender_email;
        $mail->oauthClientId = $clientId;
        $mail->oauthClientSecret = $clientSecret;
        $mail->oauthRefreshToken = $refreshToken;
        $mail->oauthAccessToken = $oauthToken;

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($sender_email, 'Sender');
        $mail->addAddress($recipient_email);

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}

$clientId = 'YOUR_GOOGLE_CLIENT_ID';
$clientSecret = 'YOUR_GOOGLE_CLIENT_SECRET';
$refreshToken = 'YOUR_GOOGLE_REFRESH_TOKEN';
$sender_email = 'YOUR_EMAIL@gmail.com';
$recipient_email = 'RECIPIENT_EMAIL@gmail.com';
$subject = 'Your Subject';
$body = 'Email body content';

send_email($clientId, $clientSecret, $refreshToken, $recipient_email, $subject, $body);
?>
