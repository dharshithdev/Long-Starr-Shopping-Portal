<?php
session_start();
include("../Connections/connect.php");
include("../Connections/authorization.php");

// --- TODAY'S ORDERS ---
$stmtToday = $conn->prepare("SELECT COUNT(*) as total FROM orders WHERE DATE(creationDate) = CURDATE()");
$stmtToday->execute();
$resultToday = $stmtToday->get_result()->fetch_assoc();
$totalToday = $resultToday['total'] ?? 0;
$stmtToday->close();

// --- THIS MONTH'S ORDERS ---
$stmtMonth = $conn->prepare("SELECT COUNT(*) as total FROM orders WHERE MONTH(creationDate) = MONTH(CURDATE()) AND YEAR(creationDate) = YEAR(CURDATE())");
$stmtMonth->execute();
$resultMonth = $stmtMonth->get_result()->fetch_assoc();
$totalMonth = $resultMonth['total'] ?? 0;
$stmtMonth->close();

// --- TOTAL WORTH ---
$stmtWorth = $conn->prepare("SELECT SUM(total) as worth FROM orders");
$stmtWorth->execute();
$resultWorth = $stmtWorth->get_result()->fetch_assoc();
$totalWorth = $resultWorth['worth'] ?? 0;
$stmtWorth->close();

$stmtPending = $conn->prepare("SELECT COUNT(*) as pending FROM trackorder WHERE orderStatus = 'Order Received'");
$stmtPending->execute();
$resultPending = $stmtPending->get_result()->fetch_assoc();
$totalPending = $resultPending['pending'] ?? 0;
$stmtPending->close();

$stmtCancelled = $conn->prepare("SELECT COUNT(*) as cancelled FROM trackorder WHERE orderStatus = 'Cancelled'");
$stmtCancelled->execute();
$resultCancelled = $stmtCancelled->get_result()->fetch_assoc();
$totalCancelled = $resultCancelled['cancelled'] ?? 0;
$stmtCancelled->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Styles/styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="Assets/icon.png">
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <?php include("Includes/header.php"); ?>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64">
            <?php include("Includes/side-bar.php"); ?>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-6 sm:p-10 md:p-12">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-md rounded-xl p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-700">Today's Orders</h2>
                    <p class="text-3xl font-bold text-indigo-600 mt-2"><?php echo $totalToday; ?></p>
                </div>

                <div class="bg-white shadow-md rounded-xl p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-700">This Month's Orders</h2>
                    <p class="text-3xl font-bold text-green-600 mt-2"><?php echo $totalMonth; ?></p>
                </div>

                <div class="bg-white shadow-md rounded-xl p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-700">Total Worth (₹)</h2>
                    <p class="text-3xl font-bold text-red-600 mt-2">₹<?php echo number_format($totalWorth); ?></p>
                </div>

                <div class="bg-white shadow-md rounded-xl p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-700">Pending Orders</h2>
                    <p class="text-3xl font-bold text-red-600 mt-2"><?php echo number_format($totalPending); ?></p>
                </div>
                
                <div class="bg-white shadow-md rounded-xl p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-700">Cancelled Orders</h2>
                    <p class="text-3xl font-bold text-red-600 mt-2"><?php echo number_format($totalCancelled); ?></p>
                </div>

                <div class="bg-white shadow-md rounded-xl p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-700">Status</h2>
                    <p class="text-3xl font-bold text-green-600 mt-2">1</p>
                </div>
            </div>
        </div>
    </div>

    <?php include("Includes/footer.php"); ?>
</body>
</html>
