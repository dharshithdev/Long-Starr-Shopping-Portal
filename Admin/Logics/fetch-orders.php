<?php
include('../Connections/connect.php');

$limit = 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$query = "
    SELECT o.id AS order_id, u.username, u.address, p.productName, o.quantity, o.price, o.total, o.creationDate
    FROM orders o
    JOIN users u ON o.userId = u.id
    JOIN products p ON o.productId = p.id
    ORDER BY o.id DESC
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $query);
$orders = [];

while($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);
exit;
?>
