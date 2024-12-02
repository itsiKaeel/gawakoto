<?php
// Load environment variables
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendVerificationEmail($userEmail, $verificationToken) {
    $mail = new PHPMailer(true);  

    try {
        // SMTP setup
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                        
        $mail->SMTPAuth   = true;                                    
        $mail->Username   = getenv('thisisjm01@gmail.com'); // Use the environment variable
        $mail->Password   = getenv('unkn wjqk ieti icbz'); // Use the environment variable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port       = 587;                                    

        // Recipients
        $mail->setFrom(getenv('MAIL_USERNAME'), 'Your Website');
        $mail->addAddress($userEmail);  

        // Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Email Verification for Your Account';
        $mail->Body    = 'Hello, <br><br> Please verify your email address by clicking the link below: <br> 
                        <a href="http://http://localhost/gawako/gawakoto/welcome.php?token=' . $verificationToken . '">Verify your email</a>';

        $mail->send();
        echo 'Verification email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
