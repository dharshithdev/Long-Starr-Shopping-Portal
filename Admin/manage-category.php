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
    <link href="Styles/manage-category.css" rel="stylesheet">

</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Categories</h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">SL No</th>
                    <th class="px-4 py-2 border">Category Name</th>
                    <th class="px-4 py-2 border">Description</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM category ORDER BY id DESC";
                $result = mysqli_query($conn, $query);
                $sl = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border text-center'>" . $sl++ . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['categoryName']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['categoryDescription']) . "</td>";
                    echo "<td class='px-4 py-2 border text-center'>";
                    echo "<a href='update-category.php?id=" . $row['id'] . "' class='bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded'>Update</a>";
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
