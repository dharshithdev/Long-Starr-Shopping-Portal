<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /longstarr/log-in.php");
    exit();
} else {
    $userId = $_SESSION['user_id'];
}
?>
