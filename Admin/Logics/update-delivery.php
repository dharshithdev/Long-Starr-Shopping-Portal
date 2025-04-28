<?php
include("../Connections/connect.php");

$order_id = $_POST['order_id'];
$expected_delivery = $_POST['expected_delivery'];

$query = "UPDATE trackorder SET expectedDelivery ='$expected_delivery' WHERE id='$order_id'";
mysqli_query($conn, $query);

header("Location: ../update-order.php?id=$order_id");
exit();
