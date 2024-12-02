<?php
$is_invalid = false;

require_once 'vendor/autoload.php';  // Ensure this line is at the top

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

// Google Client setup
$googleClient = new Google_Client();
$googleClient->setClientId('838314116108-m42083vg8o7ush5bi49cn06lb3jkic7u.apps.googleusercontent.com');
$googleClient->setClientSecret('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');
$googleClient->setRedirectUri('http://localhost/gawako/gawakoto/callback.php');  // Set your redirect URI
$googleClient->addScope('email');
$googleClient->addScope('profile');

// Handle form submission for normal login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM users WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        // Check if password matches
        if (password_verify($_POST["password"], $user["password_hash"])) {
            // Check if email is verified
            if ($user["email_verified"] == 0) {
                $is_invalid = "Please verify your email before logging in.";
            } else {
                session_start();
                session_regenerate_id();
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["role"] = $user["role"];

                if ($user["role"] === 'admin') {
                    header("Location: admin-dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        }
    }

    if (!$is_invalid) {
        $is_invalid = "Invalid login credentials.";
    }
}

// Google OAuth flow
if (isset($_GET['code'])) {
    // Get the authorization code
    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

    // Set the access token to the Google Client
    $googleClient->setAccessToken($token['access_token']);

    // Get the user's profile information
    $googleService = new Google_Service_Oauth2($googleClient); // Pass Google_Client object here
    $googleAccountInfo = $googleService->userinfo->get();  // Get user info

    // Check if user already exists in your database
    $mysqli = require __DIR__ . "/database.php";
    $email = $googleAccountInfo->email;
    $name = $googleAccountInfo->name;
    $sql = sprintf("SELECT * FROM users WHERE email = '%s'", $mysqli->real_escape_string($email));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        // Check if the email is verified
        if ($user["email_verified"] == 0) {
            die("Please verify your email before logging in.");
        }

        // User exists, log them in
        session_start();
        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] === 'admin') {
            header("Location: admin-dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        // New user, create account
        $password_hash = password_hash(uniqid(), PASSWORD_BCRYPT);  // Generate random password
        $sql = "INSERT INTO users (fullname, email, password_hash, role, email_verified) VALUES (?, ?, ?, 'client', 0)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password_hash);

        if ($stmt->execute()) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $mysqli->insert_id;
            $_SESSION["role"] = 'client';
            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Login</h1>

    <?php if ($is_invalid): ?>
        <em><?= htmlspecialchars($is_invalid) ?></em>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post">
        <div>
            <input type="email" id="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
        </div>
        <div>
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <button>Login</button>
    </form>

    <hr>

    <!-- Google Login Button -->
    <a href="<?= $googleClient->createAuthUrl() ?>"><button>Login with Google</button></a>

</body>
</html>
