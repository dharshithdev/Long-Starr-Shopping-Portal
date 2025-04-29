<?php
include("../Connections/connect.php");
include("../Connections/authorization.php");

$stmt = $conn->prepare("UPDATE adminlogs SET logOutTime = NOW() WHERE adminId = ? AND logOutTime = 'In'");
$stmt->bind_param("i", $adminId);
$stmt->execute();

session_start();
session_unset(); 
session_destroy();

$cookie_name = "nonexistent_cookie"; 

setcookie($cookie_name, '', time() - 3600, '/'); // Expires one hour ago

unset($_COOKIE[$cookie_name]);

header("Location: ../index.php");
exit();
?>
