<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="../Styles/styles.css" rel="stylesheet">
    <style>
        .container {
            display: flex;
            flex-direction: row;
        }
        .sidebar {
            width: 20%;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            background: #f4f4f4;
        }
        .content {
            margin-left: 22%;
            width: 75%;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Products</h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">SL No</th>
                    <th class="px-4 py-2 border">Product Name</th>
                    <th class="px-4 py-2 border">Price</th>
                    <th class="px-4 py-2 border">Availability</th>
                    <th class="px-4 py-2 border">Update</th>
                    <th class="px-4 py-2 border">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM products WHERE isDeleted != 1 ORDER BY id DESC";
                $result = mysqli_query($conn, $query);
                $sl = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    $avail = $row['availability'] == 1 ? "In Stock" : "Out Of Stock";
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border text-center'>" . $sl++ . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['productName']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . $avail . "</td>";
                    echo "<td class='px-4 py-2 border text-center'>";
                    echo "<a href='update-product.php?id=" . $row['id'] . "' class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded'>Update</a>";
                    echo "</td>";
                    echo "<td class='px-4 py-2 border text-center'>";
                    echo "<a href='Logics/delete-product.php?id=" . $row['id'] . "' class='bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded'>Delete</a>";
                    echo "</tr>";
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
