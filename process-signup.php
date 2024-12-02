<?php
// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'vendor/autoload.php';
// Include the database connection

$mysqli = require __DIR__ . "/database.php";


// Get form inputs
$name = $_POST["name"];
$email = $_POST["email"];
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Generate a random verification token
$verification_token = bin2hex(random_bytes(16));  // Generate a 32-character token

// Insert user into the database with the verification token
$sql = "INSERT INTO users (fullname, email, password_hash, verification_token) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $password_hash, $verification_token);
$stmt->execute();



$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bjbecause24@gmail.com';  // Replace with your email
    $mail->Password = 'radd khmh xxks ozcz';  // Use app password if 2FA enabled
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('bjbecause24@gmail.com', 'betloganpo');
    $mail->addAddress($email);  // Recipient's email address

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Please verify your email address';
    $mail->Body    = 'Click <a href="http://localhost/gawako/gawakoto/verify.php?token=' . $verification_token . '">here</a> to verify your email address.';

    $mail->send();
    echo 'Verification email sent. Please check your inbox.';
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
?>
