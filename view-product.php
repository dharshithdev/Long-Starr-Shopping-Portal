<?php
include("Includes/header.php");
include('Connections/connect.php');
include("Connections/verification.php");

$productFound = false;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    $query = "SELECT * FROM products WHERE id = $productId AND isDeleted != 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        $productFound = true;
        $productId = $product['id'];
        $productName = $product['productName'];
        $price = $product['price'];
        $description = $product['productDescription'];
        $availability = $product['availability'];
        $image1 = "Admin/ProductImages/{$productId}/" . $product['productImage1'];
        $image2 = "Admin/ProductImages/{$productId}/" . $product['productImage2'];
        $image3 = "Admin/ProductImages/{$productId}/" . $product['productImage3'];
        $categoryId = $product['categoryId'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $productFound ? htmlspecialchars($productName) . ' | Product View' : 'No Product Found'; ?></title>
  <link rel="stylesheet" href="Styles/styles.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 h-full flex flex-col">
 <main class="flex-grow">
<div class="container mx-auto px-4 py-8 mt-2 md:mt-4 lg:mt-6">

  <?php if ($productFound): ?>
    <div class="flex flex-col md:flex-row gap-8 bg-white p-6 rounded-lg shadow">

      <!-- Left: Image Display -->
      <div class="flex-1">
        <img id="mainImage" src="<?php echo $image1; ?>" alt="Product Image" class="w-full h-96 object-contain rounded-lg border" />
        <div class="flex justify-center gap-4 mt-4">
          <img src="<?php echo $image1; ?>" onclick="changeImage(this)" class="w-20 h-20 object-cover rounded cursor-pointer border border-gray-300 hover:border-blue-500" />
          <img src="<?php echo $image2; ?>" onclick="changeImage(this)" class="w-20 h-20 object-cover rounded cursor-pointer border border-gray-300 hover:border-blue-500" />
          <img src="<?php echo $image3; ?>" onclick="changeImage(this)" class="w-20 h-20 object-cover rounded cursor-pointer border border-gray-300 hover:border-blue-500" />
        </div>
      </div>

      <!-- Right: Product Info -->
      <div class="flex-1 space-y-4">
        <h2 class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($productName); ?></h2>
        <p class="text-xl text-blue-600 font-semibold">₹<?php echo number_format($price); ?></p>
        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($description)); ?></p>

        <?php if ($availability == 0): ?>
          <p class="text-xl text-red-600 font-semibold">Out Of Stock.</p>
        <?php endif ?>

        <div class="flex flex-col sm:flex-row items-center gap-4 mt-6">
          <form method="post" action="Logics/add-to-cart.php">
            <input type="hidden" value="<?php echo $productId ?>" name="productId">
            <button class="bg-blue-600 text-white px-3 py-2 rounded w-full sm:w-auto text-sm sm:text-base hover:bg-blue-700 transition">Add to Cart</button>
          </form>

          <form>
            <?php if ($availability == 0): ?>
              <button disabled class="bg-green-600 text-white px-3 py-2 rounded cursor-not-allowed opacity-70 text-center">Get it Now</button>
            <?php else: ?>
              <button id="buy-now-button" class="bg-green-600 text-white px-3 py-2 rounded w-full sm:w-auto text-sm sm:text-base hover:bg-green-700 transition" onclick="redirectToOrder(<?php echo $productId; ?>)">Get it Now</button>
            <?php endif ?>
          </form>

          <form method="post" action="Logics/add-to-wishlist.php">
            <input type="hidden" value="<?php echo $productId ?>" name="productId">
            <button class="flex items-center justify-center text-red-500 hover:text-red-600 transition w-full sm:w-auto">
              <img src="Assets/wishlist2.png" alt="Wishlist" class="w-7 h-7">
            </button>
          </form>
        </div>

      </div>
    </div>

    <?php include("Includes/related-products.php"); ?>

  <?php else: ?>
    <div class="bg-white text-center py-20 rounded shadow">
      <h2 class="text-2xl font-bold text-gray-700">No Product Found</h2>
      <p class="text-gray-500 mt-2">The product you are looking for might have been removed or does not exist.</p>
    </div>
  <?php endif; ?>
</div>
</main>
<?php include("Includes/footer.php") ?>
<script src="/longstarr/Scripts/view-product.js"></script>
</body>
</html>
