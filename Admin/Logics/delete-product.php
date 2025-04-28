<?php 
include("../Connections/connect.php");    
include("../Connections/authorization.php");    

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($productId == 0) {
    header("Location: ./manage-products.php");
} else {
    $true = true;
    $stmt = $conn->prepare( "UPDATE products SET isDeleted = ? WHERE id = ?");
    $stmt->bind_param("si", $true, $productId);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $productName = $row['productName'];
    $productPrice = $row['price'];
    $productImage = $row['productImage1'];

    $stmt = $conn->prepare( "INSERT INTO deletedProducts (productId, productName, productPrice, productImage) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $productId, $productName, $productPrice, $productImage);
    $stmt->execute();
    
    header("Location: ../manage-products.php");
}

?>