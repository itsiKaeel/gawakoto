<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

// Initialize Google Client
$googleClient = new Google_Client();
$googleClient->setClientId('838314116108-m42083vg8o7ush5bi49cn06lb3jkic7u.apps.googleusercontent.com'); // Replace with your client ID
$googleClient->setClientSecret('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'); // Replace with your client secret
$googleClient->setRedirectUri('http://localhost/gawako/gawakoto/callback.php'); // Replace with your redirect URI

// Check if the "code" parameter is present in the URL
if (isset($_GET['code'])) {
    // Exchange the authorization code for an access token
    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        echo 'Error fetching access token: ' . htmlspecialchars($token['error_description']);
        exit;
    }

    // Set the access token in the client
    $googleClient->setAccessToken($token['access_token']);

    // Fetch the user's profile information
    $googleService = new Google_Service_Oauth2($googleClient);
    $userInfo = $googleService->userinfo->get();

    // Save user information in the session
    $_SESSION['name'] = $userInfo->name;
    $_SESSION['email'] = $userInfo->email;
    $_SESSION['picture'] = $userInfo->picture;

    // Redirect to the welcome page
    header('Location: welcome.php');
    exit;
} else {
    echo 'Authorization code not received. Please try logging in again.';
    exit;
}
?>
