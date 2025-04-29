<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$productName = $productDescription = "";
$price = $availability = $categoryId = 0;

// Fetch existing product details
if ($productId > 0) {
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $categoryId = $row['categoryId'];
        $productName = $row['productName'];
        $productDescription = $row['productDescription'];
        $price = $row['price'];
        $availability = $row['availability'];
    } else {
        echo "<script>alert('Product not found'); window.location.href='manage-products.php';</script>";
        exit();
    }
}

// Get category list
$catQuery = "SELECT * FROM category";
$catResult = mysqli_query($conn, $catQuery);
$categories = [];
while ($catRow = mysqli_fetch_assoc($catResult)) {
    $categories[] = $catRow;
}

// Handle update form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedCategoryId = intval($_POST['categorySelect']);
    $updatedProName = mysqli_real_escape_string($conn, $_POST['productName']);
    $updatedDesc = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $updatedPrice = floatval($_POST['productPrice']);
    $updatedAvailability = $_POST['availability'] === "available" ? 1 : 0;

    $stmt = $conn->prepare("UPDATE products SET categoryId = ?, productName = ?, productDescription = ?, price = ?, availability = ? WHERE id = ?");
    $stmt->bind_param("issdii", $updatedCategoryId, $updatedProName, $updatedDesc, $updatedPrice, $updatedAvailability, $productId);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully'); window.location.href='manage-products.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update product');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
    <link href="../Styles/styles.css" rel="stylesheet">
    <link href="Styles/update-product.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Update Product</h1>

        <form method="POST" class="bg-white p-6 rounded shadow-md max-w-lg mx-auto">

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Product Category</label>
                <select name="categorySelect" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $categoryId ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($cat['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
                <input type="text" name="productName" value="<?= htmlspecialchars($productName); ?>" 
                    class="w-full px-4 py-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Product Description</label>
                <textarea name="productDescription" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded" required><?= htmlspecialchars($productDescription); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Product Price</label>
                <input type="number" step="0.01" name="productPrice" value="<?= htmlspecialchars($price); ?>" 
                    class="w-full px-4 py-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Availability</label>
                <select name="availability" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                    <option value="available" <?= $availability == 1 ? 'selected' : ''; ?>>Available</option>
                    <option value="outofstock" <?= $availability == 0 ? 'selected' : ''; ?>>Out Of Stock</option>
                </select>
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
