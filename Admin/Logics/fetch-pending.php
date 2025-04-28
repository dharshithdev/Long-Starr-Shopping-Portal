<?php

include('../Connections/connect.php');

$limit = 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$query = "
    SELECT 
        t.id AS order_id, 
        u.username, 
        u.address, 
        p.productName, 
        o.quantity, 
        o.price, 
        o.total, 
        o.creationDate
    FROM trackorder t
    JOIN users u ON t.userId = u.id
    JOIN products p ON t.productId = p.id
    JOIN orders o ON o.id = t.orderId
    WHERE t.orderStatus != 'Delivered'
    ORDER BY t.id DESC
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $query);
$orders = [];

if (!$result) {
    http_response_code(500); // Send proper error code to client
    echo json_encode(["error" => "Database query failed", "details" => mysqli_error($conn)]);
    exit;
}

while($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);
exit;
?>
