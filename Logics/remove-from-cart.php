<?php
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cartId'])) {
    $cartId = intval($_POST['cartId']);

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND userId = ?");
    $stmt->bind_param("ii", $cartId, $userId);
    $stmt->execute();
}

header("Location: ../cart.php");
exit();
