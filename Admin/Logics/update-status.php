<?php
include("../Connections/connect.php");

$order_id = $_POST['order_id'];
$status = $_POST['status'];

$query = "UPDATE trackorder SET orderStatus='$status' WHERE id='$order_id'";
mysqli_query($conn, $query);

header("Location: ../update-order.php?id=$order_id");
exit();
