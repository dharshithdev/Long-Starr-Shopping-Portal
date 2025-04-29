<?php
include("Includes/header.php");
include('Connections/connect.php');
include("Connections/authorization.php");

// These lines are NOT needed for infinite scroll:
$limit = 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Total Orders</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="../Styles/styles.css" rel="stylesheet">
    <link href="Styles/todays-order.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="Assets/icon.png">
</head>
<body class="bg-gray-100">

<div class="flex">
<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="table-container p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Today's Orders</h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Sl No</th>
                    <th class="px-4 py-2 border">Order ID</th>
                    <th class="px-4 py-2 border">Username</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border">Order Item</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Price</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody id="orders-table-body"></tbody>
        </table>
        <div id="loading" class="text-center py-4 hidden">Loading...</div>
    </div>
</div>
</div>

<script defer src="Scripts/todays-order.js"></script>

</body>
</html>
<?php include("Includes/footer.php"); ?>
