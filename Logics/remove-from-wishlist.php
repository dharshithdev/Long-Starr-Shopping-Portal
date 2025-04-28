<?php
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlistId'])) {
    $wishlistId = intval($_POST['wishlistId']);

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND userId = ?");
    $stmt->bind_param("ii", $wishlistId, $userId);
    $stmt->execute();
}

header("Location: ../wishlist.php"); 
exit();
