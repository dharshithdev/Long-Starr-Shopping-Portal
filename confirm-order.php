<?php
include("Includes/header.php");
include('Connections/connect.php');
include("Connections/authorization.php");

$_SESSION['user_id'] = $userId;

$productId = $_GET['id'] ?? null;

if (!$productId || !is_numeric($productId)) {
    $product = null;
} else {
    $stmt = $conn->prepare("SELECT state, pinCode, address FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user['pinCode'] == null || $user['address'] == null || $user['state'] == null) {
        header("Location: change-address.php");
        exit();
    }

    $productQuery = $conn->prepare("SELECT p.*, c.categoryName FROM products p JOIN category c ON p.categoryId = c.id WHERE p.id = ? AND p.isDeleted != 1");
    $productQuery->bind_param("i", $productId);
    $productQuery->execute();
    $productResult = $productQuery->get_result();
    $product = $productResult->fetch_assoc();

    // Get user info
    $userQuery = "SELECT * FROM users WHERE id = 1";
    $userResult = mysqli_query($conn, $userQuery);
    $user = mysqli_fetch_assoc($userResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Order</title>
  <link rel="stylesheet" href="Styles/styles.css">
</head>
<body class="bg-gray-100 h-full flex flex-col">

<main class="flex-grow">
<div class="container mx-auto px-4 py-6">
  <?php if (!$product): ?>
    <div class="flex justify-center items-center h-[60vh]">
      <p class="text-center text-2xl text-gray-600 font-semibold">No Product Found</p>
    </div>
  <?php else: ?>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg flex flex-col lg:flex-row gap-6">

      <!-- Product Image -->
      <div class="w-full lg:w-1/2">
        <img src="Admin/ProductImages/<?php echo $product['id']; ?>/<?php echo $product['productImage1']; ?>" alt="Product" class="w-full h-60 sm:h-80 lg:h-96 object-contain rounded-lg border">
      </div>

      <!-- Product & Shipping Details -->
      <div class="w-full lg:w-1/2 flex flex-col justify-between">

        <!-- Product Info -->
        <div class="mb-4 lg:mb-6">
          <h2 class="text-xl lg:text-2xl font-bold mb-2"><?php echo htmlspecialchars($product['productName']); ?></h2>
          <p class="text-gray-600 mb-1 text-sm lg:text-base"><span class="font-medium"><?php echo htmlspecialchars($product['categoryName']); ?></span></p>
          <p class="text-gray-600 mb-1 text-sm lg:text-base"><span class="text-green-600 font-bold">₹<?php echo number_format($product['price']); ?></span></p>
          <p class="text-gray-600 mt-2 text-sm lg:text-base"><?php echo htmlspecialchars($product['productDescription']); ?></p>
        </div>

        <!-- Shipping Info -->
        <div class="mb-4 lg:mb-6 text-sm lg:text-base">
          <h3 class="text-lg lg:text-xl font-semibold mb-2">Shipping Details</h3>
          <p><strong></strong> <?php echo htmlspecialchars($user['username']); ?></p>
          <p><strong></strong> <?php echo htmlspecialchars($user['phoneNumber']); ?></p>
          <p><strong></strong> <?php echo htmlspecialchars($user['address']); ?></p>
        </div>

        <!-- Order Form -->
        <form method="POST" action="payment.php?id=<?php echo $productId; ?>">
          <label for="quantity" class="block mb-2 text-sm lg:text-base">Quantity</label>
          <input type="number" name="quantity" value="1" min="1" required class="border rounded px-2 py-1 w-full sm:w-24 mb-4">

          <!-- Buttons -->
          <div class="flex flex-col sm:flex-row gap-3 mt-4">
            <button type="button" onclick="redirectToChange()" class="bg-blue-600 text-white px-4 py-2 rounded w-full sm:w-auto text-sm lg:text-base hover:bg-blue-700 transition">Change Shipping Details</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded w-full sm:w-auto text-sm lg:text-base hover:bg-green-700 transition">Proceed to Pay</button>
          </div>
        </form>

      </div>
    </div>
  <?php endif; ?>
</div>
</main>
<?php include("Includes/footer.php"); ?>

<script src="/longstarr/Scripts/confirm-order.js"></script>
</body>
</html>

