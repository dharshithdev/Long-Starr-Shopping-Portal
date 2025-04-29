<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");


$categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$categoryName = "";
$categoryDescription = "";

// Fetch current category data
if ($categoryId > 0) {
    $query = "SELECT * FROM category WHERE id = $categoryId";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $categoryName = $row['categoryName'];
        $categoryDescription = $row['categoryDescription'];
    } else {
        echo "<script>alert('Category not found'); window.location.href='manage-category.php';</script>";
        exit();
    }
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $updatedDesc = mysqli_real_escape_string($conn, $_POST['categoryDescription']);

    $updateQuery = "UPDATE category SET categoryName = '$updatedName', categoryDescription = '$updatedDesc' WHERE id = $categoryId";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Category updated successfully'); window.location.href='manage-category.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update category');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Category</title>
    <link href="../Styles/styles.css" rel="stylesheet">
    <link href="Styles/update-category.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Update Category</h1>

        <form method="POST" class="bg-white p-6 rounded shadow-md max-w-lg mx-auto">
            <div class="mb-4">
                <label for="categoryName" class="block text-gray-700 font-semibold mb-2">Category Name</label>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($categoryName); ?>" 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="categoryDescription" class="block text-gray-700 font-semibold mb-2">Category Description</label>
                <textarea id="categoryDescription" name="categoryDescription" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" required><?php echo htmlspecialchars($categoryDescription); ?></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-semibold">Update</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
<?php include("Includes/footer.php"); ?>
