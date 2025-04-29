<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deleted Products</title>
    <link href="../Styles/styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="Assets/icon.png">
    <link href="Styles/print-invoice.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Pending Orders </h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">SL No</th>
                    <th class="px-4 py-2 border">Order Id</th>
                    <th class="px-4 py-2 border">Username</th>
                    <th class="px-4 py-2 border">Product</th>
                    <th class="px-4 py-2 border">Total</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Print</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT 
                t.id AS orderId, 
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
            ORDER BY t.id DESC";
                $result = mysqli_query($conn, $query);
                $sl = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border text-center'>" . $sl++ . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['orderId']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['productName']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['total']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['creationDate']) . "</td>";
                    echo "<td class='px-4 py-2 border text-center'>";
                    echo "<a href='get-print.php?id=" . $row['orderId'] . "' class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded'>Print</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
<?php include("Includes/footer.php"); ?>
