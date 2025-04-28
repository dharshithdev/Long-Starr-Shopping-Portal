<?php
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trackId'])) {
    $trackId = intval($_POST['trackId']);
    $newStatus = "Cancelled";
    echo "<script>console.log('Hell')</script>";

    $stmt = $conn->prepare("UPDATE trackorder SET orderStatus = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $trackId);
    $stmt->execute();
}

header("Location: ../view-orders.php"); 
exit();
