<?php
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productId'])) {
    $productId = intval($_POST['productId']);

    $stmt = $conn->prepare("INSERT INTO wishlist (productId, userId) VALUES (?, ?)");
    $stmt->bind_param("ii", $productId, $userId);
    $stmt->execute();
}

header("Location: ../wishlist.php");
exit();
