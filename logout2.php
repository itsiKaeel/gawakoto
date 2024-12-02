<?php
if (!isset($_SESSION['name'])) {
    header('Location: activate.php');
    exit;
}

?>
