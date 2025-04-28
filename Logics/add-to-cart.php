<?php
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productId'])) {
    $productId = intval($_POST['productId']);

    $stmt = $conn->prepare("INSERT INTO cart (userId, productId) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
}

header("Location: ../cart.php");
exit();
