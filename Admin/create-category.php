<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $categoryDescription = mysqli_real_escape_string($conn, $_POST['categoryDescription']);
    $image = $_FILES['categoryImage'];

    // Get max categoryId
    $result = mysqli_query($conn, "SELECT MAX(categoryId) AS maxId FROM category");
    $row = mysqli_fetch_assoc($result);
    $newCategoryId = $row['maxId'] ? $row['maxId'] + 1 : 1;

    $folderPath = "CategoryImages/" . $newCategoryId;
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Handle image upload
    $imageName = $image['name'];
    $imageTmp = $image['tmp_name'];
    $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
    $newImageName = $newCategoryId . '.' . $imageExt;
    $destination = $folderPath . '/' . $newImageName;

    if (move_uploaded_file($imageTmp, $destination)) {
        // Insert into category table
        $insert = "INSERT INTO category (categoryId, categoryName, categoryImage, categoryDescription)
                   VALUES ($newCategoryId, '$categoryName', '$newImageName', '$categoryDescription')";
        if (mysqli_query($conn, $insert)) {
            echo "<script>alert('Category created successfully!');</script>";
        } else {
            echo "<script>alert('Failed to insert category.');</script>";
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
  <title>Create Category</title>
   <link rel="stylesheet" href="../Styles/styles.css">
   <link rel="icon" type="image/png" href="Assets/icon.png">
</head>
<body class="bg-gray-100">

<div class="flex">
  <?php include("Includes/side-bar.php"); ?>

  <main class="flex-1 p-8 bg-white min-h-screen">
    <h1 class="text-2xl font-bold mb-6">Create New Category</h1>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 w-full max-w-xl">
      <div>
        <label class="block font-semibold mb-1" for="categoryName">Category Name</label>
        <input type="text" name="categoryName" id="categoryName" required class="w-full px-4 py-2 border rounded">
      </div>

      <div>
        <label class="block font-semibold mb-1" for="categoryDescription">Category Description</label>
        <textarea name="categoryDescription" id="categoryDescription" rows="4" required class="w-full px-4 py-2 border rounded"></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1" for="categoryImage">Category Image</label>
        <input type="file" name="categoryImage" id="categoryImage" accept="image/*" required class="w-full">
      </div>

      <div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Create Category</button>
      </div>
    </form>
  </main>
</div>

</body>
</html>
