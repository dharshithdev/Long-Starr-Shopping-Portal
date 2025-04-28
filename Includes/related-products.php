<?php
include("Connections/connect.php");
include("Connections/verification.php");
if (isset($categoryId)) {
    $query = "SELECT * FROM products WHERE categoryId = $categoryId AND isDeleted != 1";
    $result = mysqli_query($conn, $query);
 
} else {
    echo "<p class='text-center text-gray-500'>No category selected.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="Styles/styles.css">
</head>
<body class="bg-gray-100">

  <div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-black-700">Related Products</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
      <?php while ($row = mysqli_fetch_assoc($result)) { 
        $productId = $row['id'];
        $productName = $row['productName'];
        $price = $row['price'];
        $imagePath = "Admin/ProductImages/{$productId}/" . $row['productImage1'];
      ?>
         <a href="view-product.php?id=<?php echo $productId; ?>" 
            class="bg-white rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 p-4 flex flex-col items-center text-center group">
            <img src="<?php echo $imagePath; ?>" 
              alt="<?php echo htmlspecialchars($productName); ?>" 
              class="w-40 sm:w-48 md:w-56 h-24 sm:h-32 md:h-40 object-contain rounded-lg mb-3 group-hover:opacity-90">
           <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-200">
             <?php echo htmlspecialchars($productName); ?>
           </h3>
           <p class="text-blue-600 font-bold group-hover:text-blue-800 transition-colors duration-200">
             ₹<?php echo number_format($price); ?>
           </p>
        </a>
      <?php } ?>
    </div>
  </div>
</body>
</html>
