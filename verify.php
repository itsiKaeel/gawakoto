<?php
// Include the database connection
$mysqli = require __DIR__ . "/database.php";

// Check if a token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Prepare SQL to check if the token exists in the database
    $sql = "SELECT * FROM users WHERE verification_token = ?";
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists and token is valid
    if ($user) {
        // Mark the email as verified
        $update_sql = "UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = ?";
        $update_stmt = $mysqli->stmt_init();

        if (!$update_stmt->prepare($update_sql)) {
            die("SQL error: " . $mysqli->error);
        }

        // Bind the token and execute the update
        $update_stmt->bind_param("s", $token);
        $update_stmt->execute();

        echo "Your email has been verified successfully!";
    } else {
        echo "Invalid verification link.";
    }

    // Close the database connection
    $stmt->close();
    $mysqli->close();
} else {
    echo "No verification token provided.";
}
?>
