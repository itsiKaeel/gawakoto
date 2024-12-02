<?php
$token = $_GET['token'];

$mysqli = require __DIR__ . "/database.php";

// Check if the token exists and is valid (not expired)
$sql = "SELECT * FROM users WHERE verification_token = ? AND token_expires > NOW()";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Token is valid, mark the email as verified
    $sql = "UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    
    echo "Your email has been successfully verified!";
} else {
    echo "Invalid or expired token.";
}
?>
