<?php 
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId']) && isset($_POST['productId'])) {
    $productId = intval($_POST['productId']);
    $userId = intval($_POST['userId']);
    $quantity = intval($_POST['quantity']);
    $mode = $_POST['mode'];
    
    $query = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $query->bind_param("i", $productId);
    $query->execute();
    $result = $query->get_result();
    $product = $result->fetch_assoc();
    $price = $product['price'];

    $total = $quantity * $price;

    $stmt = $conn->prepare("INSERT INTO orders (userId, productId, quantity, price, total, mode) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiis", $userId, $productId, $quantity, $price, $total, $mode);
    $stmt->execute();

    $find = $conn->prepare("SELECT MAX(id) FROM ORDERS WHERE userId = ?");
    $find->bind_param("i", $userId);
    $find->execute();
    $resFind = $find->get_result();
    $outPut = $resFind->fetch_array();
    $orderId = $outPut[0];

    $stmt = $conn->prepare("INSERT INTO trackorder (orderId, userId, productId) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $orderId, $userId, $productId); 
    $stmt->execute();
}

if($mode == "cod") {
    header("Location: ../order-placed.php");
} elseif ($mode == "online") {
    header("Location: ../success.php");
}
?>