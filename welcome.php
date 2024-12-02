<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
    <p>Your email: <?= htmlspecialchars($_SESSION['email']) ?></p>
    <img src="<?= htmlspecialchars($_SESSION['picture']) ?>" alt="Profile Picture">
    <br><br>

    <!-- Logout Button -->
    <a href="logout2.php"><button>Logout</button></a>  <!-- This will call logout.php to log out the user -->
</body>
</html>
