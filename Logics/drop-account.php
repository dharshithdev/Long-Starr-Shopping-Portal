<?php
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

$password = $_POST['password'] ?? '';

if (empty($password)) {
    $_SESSION['error'] = "Password is required.";
    header("Location: ../delete-account.php");
    exit();
}

// Fetch the hashed password from DB
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Delete user account
        $delStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $delStmt->bind_param("i", $userId);
        $delStmt->execute();
        $delStmt->close();

        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header("Location: ../goodbye.php"); 
        exit();
    } else {
        $_SESSION['error'] = "Incorrect password. Please try again.";
        header("Location: ../delete-account.php");
        exit();
    }
} else {
    $_SESSION['error'] = "User not found.";
    header("Location: ../delete-account.php");
    exit();
}
