<?php
include("Includes/header.php");
include('Connections/connect.php');
include("Connections/authorization.php");

$_SESSION['user_id'] = $userId;

// Validate product ID
$productId = $_GET['id'] ?? null;
if (!$productId || !is_numeric($productId)) {
    echo "<div style='padding: 20px; color: red;'>Invalid product ID provided.</div>";
    include("Includes/footer.php");
    exit();
}

// Validate user shipping address
$stmt = $conn->prepare("SELECT state, pinCode, address FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData || $userData['pinCode'] == null || $userData['address'] == null || $userData['state'] == null) {
    header("Location: change-address.php");
    exit();
}

// Get product
$productQuery = "SELECT p.*, c.categoryName FROM products p JOIN category c ON p.categoryId = c.id WHERE p.id = ? AND p.isDeleted != 1";
$stmt = $conn->prepare($productQuery);
$stmt->bind_param("i", $productId);
$stmt->execute();
$productResult = $stmt->get_result();
$product = $productResult->fetch_assoc();

if($product['productName'] == null) {
  header("Location: error.php");
}

// Get user info for display (you might want to use $userId instead of hardcoded id = 1)
$userQuery = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();


$quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
$total = $product['price'] * $quantity;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Order</title>
  <link rel="stylesheet" href="Styles/styles.css">
  <link rel="icon" type="image/png" href="Assets/icon.png">
</head>
<body class="bg-gray-100">
  <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg flex flex-col lg:flex-row gap-6">

      <!-- Product Image -->
      <div class="w-full lg:w-1/2">
        <img src="Admin/ProductImages/<?php echo $product['id']; ?>/<?php echo $product['productImage1']; ?>" alt="Product" class="w-full h-64 sm:h-80 object-contain rounded-lg border">
      </div>

      <!-- Product & Shipping Details -->
      <div class="w-full lg:w-1/2 flex flex-col justify-between">
        <div class="mb-4">
          <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($product['productName']); ?></h2>
          <p class="text-gray-600 text-sm sm:text-base mb-1">Category: <span class="font-medium"><?php echo htmlspecialchars($product['categoryName']); ?></span></p>
          <p class="text-gray-600 text-sm sm:text-base mb-1">Price: <span class="text-green-600 font-bold">₹<?php echo number_format($product['price']); ?></span></p>
          <p class="text-gray-600 text-sm sm:text-base mt-2">Quantity: <?php echo $quantity; ?></p>
          <p class="text-gray-600 text-sm sm:text-base mt-2">Total: <span class="text-green-600 font-bold">₹<?php echo $total; ?></span></p>
        </div>

        <!-- Payment Mode -->
        <div class="mb-4 text-sm sm:text-base">
          <h3 class="text-lg font-semibold mb-2">Payment Mode</h3>
          <label class="block mb-1"><input type="radio" name="payMode" value="cod" checked> Cash On Delivery</label>
          <label class="block mb-1 text-gray-400"><input type="radio" name="payMode" value="card" disabled> Card Payment</label>
          <label class="block mb-4 text-gray-400"><input type="radio" name="payMode" value="upi" disabled> UPI Payment</label>
          <p class="text-gray-600 text-sm"><strong>NOTE:</strong> Cash On Delivery is the only available option at the moment.</p>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-3 mt-4">
          <button onclick="showPopup()" class="bg-green-600 text-white px-4 py-2 rounded w-full sm:w-auto text-sm hover:bg-green-700 transition">Confirm Order</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Pop-up Modal -->
  <form method="POST" action="Logics/book-item.php">
    <div id="popup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
      <div class="bg-white w-11/12 max-w-sm p-4 sm:p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-lg font-semibold mb-4">Confirm Your Order</h2>
        <p class="mb-6 text-sm">Are you sure you want to place this order?</p>
        <div class="flex justify-center gap-4">
          <input type="hidden" name="mode" id="modeInput">
          <input type="hidden" name="userId" value="<?php echo $userId; ?>">
          <input type="hidden" name="productId" value="<?php echo $productId; ?>">
          <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Yes</button>
          <button type="button" onclick="hidePopup()" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
        </div>
      </div>
    </div>
  </form>

  <script src="/longstarr/Scripts/payment.js"></script>
</body>
</html>
<?php include("Includes/footer.php"); ?>
