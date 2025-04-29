<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

// Fetch Category
$stmt = $conn->prepare("SELECT categoryName FROM category");
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['categoryName'];
}

$categories = array_unique($categories);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $categoryNameSelect = $_POST['categorySelect'];
    $price = $_POST['productPrice'];
    $image1 = $_FILES['productImage1'];
    $image2 = $_FILES['productImage2'];
    $image3 = $_FILES['productImage3'];

    // Get max categoryId
    $result = mysqli_query($conn, "SELECT MAX(id) AS maxId FROM products");
    $row = mysqli_fetch_assoc($result);
    $newProductId = $row['maxId'] ? $row['maxId'] + 1 : 1;

    $folderPath = "ProductImages/" . $newProductId;
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Handle image upload
    $imageName1 = $image1['name'];
    $imageTmp1 = $image1['tmp_name'];
    $imageExt1 = pathinfo($imageName1, PATHINFO_EXTENSION);
    $newImageName1 = $newProductId . '_1.' . $imageExt1;
    $destination1 = $folderPath . '/' . $newImageName1;

    $imageName2 = $image2['name'];
    $imageTmp2 = $image2['tmp_name'];
    $imageExt2 = pathinfo($imageName2, PATHINFO_EXTENSION);
    $newImageName2 = $newProductId . '_2.' . $imageExt2;
    $destination2 = $folderPath . '/' . $newImageName2;

    $imageName3 = $image3['name'];
    $imageTmp3 = $image3['tmp_name'];
    $imageExt3 = pathinfo($imageName3, PATHINFO_EXTENSION);
    $newImageName3 = $newProductId . '_3.' . $imageExt3;
    $destination3 = $folderPath . '/' . $newImageName3;

    if (move_uploaded_file($imageTmp1, $destination1) && move_uploaded_file($imageTmp2, $destination2) && move_uploaded_file($imageTmp3, $destination3)) {
        // Insert into category table
        $stmt = $conn->prepare("SELECT categoryId FROM category WHERE categoryName = ?");
        $stmt->bind_param("s", $categoryNameSelect);
        $stmt->execute();
        $result = $stmt->get_result();
        $row2 = $result->fetch_assoc();
        $categoryId = $row2['categoryId'];

        $insert = "INSERT INTO products (categoryId , productName, productDescription, price, availability, productImage1, productImage2, productImage3)
                   VALUES ('$categoryId', '$productName', '$productDescription', '$price', 1, '$newImageName1', '$newImageName2', '$newImageName3')";
        if (mysqli_query($conn, $insert)) {
            echo "<script>alert('Product Inserted successfully!');</script>";
        } else {
            echo "<script>alert('Failed to insert Product.');</script>";
        }
    } else {
        echo "<script>alert('Image upload failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Insert Products</title>
   <link rel="stylesheet" href="../Styles/styles.css">
   <link rel="icon" type="image/png" href="Assets/icon.png">
</head>
<body class="bg-gray-100">

<div class="flex">
  <?php include("Includes/side-bar.php"); ?>

  <main class="flex-1 p-8 bg-white min-h-screen">
    <h1 class="text-2xl font-bold mb-6">Insert Product</h1>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 w-full max-w-xl">
      <div>
        <label class="block font-semibold mb-1" for="categoryName">Product Name</label>
        <input type="text" name="productName" id="categoryName" required class="w-full px-4 py-2 border rounded">
      </div>

      <div>
      <label class="block font-semibold mb-1" for="categoryName">Product Category</label>
      <select name="categorySelect" class="border rounded px-3 py-1" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
                <?php endforeach; ?>
      </select>
      </div>

      <div>
        <label class="block font-semibold mb-1" for="categoryDescription">Product Description</label>
        <textarea name="productDescription" id="categoryDescription" rows="4" required class="w-full px-4 py-2 border rounded"></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1" for="categoryDescription">Product Price</label>
        <input name="productPrice" id="categoryDescription" rows="4" required class="w-full px-4 py-2 border rounded">
      </div>

      <div>
        <label class="block font-semibold mb-1" for="categoryImage">Product Image 1</label>
        <input type="file" name="productImage1" id="categoryImage" accept="image/*" required class="w-full">
      </div>

      <div>
        <label class="block font-semibold mb-1" for="categoryImage">Product Image 2</label>
        <input type="file" name="productImage2" id="categoryImage" accept="image/*" required class="w-full">
      </div>

      <div>
        <label class="block font-semibold mb-1" for="categoryImage">Product Image 3</label>
        <input type="file" name="productImage3" id="categoryImage" accept="image/*" required class="w-full">
      </div>

      <div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Insert Product</button>
      </div>
    </form>
  </main>
</div>

</body>
</html>
