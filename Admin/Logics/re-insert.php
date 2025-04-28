<?php 
include("../Connections/connect.php");
include("../Connections/authorization.php");

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;


$false = 0;
$stmt = $conn->prepare("UPDATE products SET isDeleted = ? WHERE id = ?");
$stmt->bind_param("ii", $false, $productId);
if($stmt->execute()) {
    $stmt = $conn->prepare("DELETE FROM deletedProducts WHERE productId = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    header("Location: ../deleted-products.php");
}

?>