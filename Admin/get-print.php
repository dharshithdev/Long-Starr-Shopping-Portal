<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

$order_id = intval($_GET['id']); // Sanitize the input

// Query to get order, product, user and tracking info
$query = "SELECT 
    o.id AS order_id,
    o.productId,
    o.userId,
    o.quantity,
    o.price,
    o.total,
    o.mode,
    t.orderStatus,
    t.expectedDelivery,
    t.orderReceived,
    p.productName,
    p.productDescription,
    p.productImage1,
    u.username,
    u.email,
    u.phoneNumber,
    u.address,
    u.pinCode
FROM orders o
JOIN products p ON o.productId = p.id
JOIN users u ON o.userId = u.id
LEFT JOIN trackorder t ON o.id = t.orderId
WHERE o.id = $order_id";

$result = mysqli_query($conn, $query);
$track_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM trackorder WHERE orderId = $order_id"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Details</title>
  <link rel="stylesheet" href="../../Styles/styles.css">
</head>
<body class="bg-gray-100">      

<div class="flex">
  <?php include("includes/side-bar.php"); ?>

  <main class="flex-1 p-6 bg-white min-h-screen">
    <h1 class="text-2xl font-bold mb-4">Order Details - #<?php echo $order_id; ?></h1>

    <!-- Order Table -->
    <div class="overflow-x-auto">
    <table class="min-w-full table-auto border border-gray-300">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">Ordered By</th>
            <th class="px-4 py-2 border">Phone</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Date</th>
            <th class="px-4 py-2 border">PIN Code</th>
            <th class="px-4 py-2 border">Address</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total_price = 0;
          mysqli_data_seek($result, 0); 
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr class='text-center'>
                      <td class='px-4 py-2 border'>{$row['username']}</td>
                      <td class='px-4 py-2 border'>{$row['phoneNumber']}</td>
                      <td class='px-4 py-2 border'>{$row['email']}</td>
                      <td class='px-4 py-2 border'>{$row['orderReceived']}</td>
                      <td class='px-4 py-2 border'>{$row['pinCode']}</td>
                      <td class='px-4 py-2 border'>{$row['address']}</td>
                    </tr>";
          }
          ?>
        </tbody>
      </table> <br/>
      <h1 class="text-2xl font-bold mb-4">Item Details</h1>

      <table class="min-w-full table-auto border border-gray-300">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">Product Name</th>
            <th class="px-4 py-2 border">Specs</th>
            <th class="px-4 py-2 border">Price</th>
            <th class="px-4 py-2 border">Quantity</th>
            <th class="px-4 py-2 border">Total</th>
            <th class="px-4 py-2 border">Payment</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total_price = 0;
          mysqli_data_seek($result, 0); // reset result pointer
          while ($row = mysqli_fetch_assoc($result)) {
              $subtotal = $row['price'] * $row['quantity'];
              $total_price += $subtotal;
              echo "<tr class='text-center'>
                      <td class='px-4 py-2 border'>{$row['productName']}</td>
                      <td class='px-4 py-2 border'>{$row['productDescription']}</td>
                      <td class='px-4 py-2 border'>₹{$row['price']}</td>
                      <td class='px-4 py-2 border'>{$row['quantity']}</td>
                      <td class='px-4 py-2 border'>₹{$subtotal}</td>
                      <td class='px-4 py-2 border'>{$row['mode']}</td>
                    </tr>";
          }
          ?>
          <tr class="bg-gray-100 font-semibold text-center">
            <td colspan="5" class="px-4 py-2 border">Total Price</td>
            <td class="px-4 py-2 border">₹<?php echo $total_price; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</div>

</body>
</html>
<?php include("Includes/footer.php"); ?>