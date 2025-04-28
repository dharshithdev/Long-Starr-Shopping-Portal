<?php
include("../Connections/connect.php");
include("../Connections/authorization.php");

$stmt = $conn->prepare("UPDATE userlogs SET loggedOut = NOW() WHERE userId = ? AND loggedOut = 'In'");
$stmt->bind_param("i", $userId);
$stmt->execute();


session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

setcookie("user_id", $_SESSION['user_id'], time() - 3600, "/");


// Redirect to index.php after logout
header("Location: ../index.php");
exit();
?>
