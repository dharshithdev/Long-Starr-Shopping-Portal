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
    <link href="Styles/deleted-products.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="Assets/icon.png">

</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Deleted products</h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">SL No</th>
                    <th class="px-4 py-2 border">Product Name</th>
                    <th class="px-4 py-2 border">Price</th>
                    <th class="px-4 py-2 border">Re-Insert</th>
                    <th class="px-4 py-2 border">Date Deleted</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM deletedProducts ORDER BY id DESC";
                $result = mysqli_query($conn, $query);
                $sl = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border text-center'>" . $sl++ . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['productName']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['productPrice']) . "</td>";
                    echo "<td class='px-4 py-2 border text-center'>";
                    echo "<a href='Logics/re-insert.php?id=" . $row['productId'] . "' class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded'>Re-Insert</a>";
                    echo "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['deletionDate']) . "</td>";
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
