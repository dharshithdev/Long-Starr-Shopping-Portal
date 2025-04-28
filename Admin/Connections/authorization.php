<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['admin_username'])) {
    header("Location: index.php");
    exit();
} else {
    $logState = $_SESSION['admin_logged_in'] = true;
    $username = $_SESSION['admin_username'];
    $adminId = $_SESSION['admin_id'];
}
?>
