<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

$order_id = intval($_GET['id']); // Sanitize the input

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
  <link rel="stylesheet" href="Styles/get-print.css">
  <link rel="icon" type="image/png" href="Assets/icon.png">


</head>

<body class="bg-gray-100">

<div class="flex">
  <?php include("includes/side-bar.php"); ?>

  <main class="flex-1 p-6 bg-white min-h-screen">
    <div class="bill-container" id="bill">

      <h1><b>Longstar</b></h1>
      <h1><b>Order ID  #<?php echo $order_id; ?></b></h1>

      <!-- Customer Details -->
      <table>
        <thead>
          <tr>
            <th>Ordered By</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Date</th>
            <th>PIN Code</th>
            <th>Address</th>
          </tr>
        </thead>
        <tbody>
          <?php
          mysqli_data_seek($result, 0);
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      <td>{$row['username']}</td>
                      <td>{$row['phoneNumber']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['orderReceived']}</td>
                      <td>{$row['pinCode']}</td>
                      <td>{$row['address']}</td>
                    </tr>";
          }
          ?>
        </tbody>
      </table>

      <!-- Item Details -->
      <h2 style="text-align:center; margin-bottom:10px;"><b>Item Details</b></h2>

      <table>
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Specs</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Payment</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total_price = 0;
          mysqli_data_seek($result, 0);
          while ($row = mysqli_fetch_assoc($result)) {
              $subtotal = $row['price'] * $row['quantity'];
              $total_price += $subtotal;
              echo "<tr>
                      <td>{$row['productName']}</td>
                      <td>{$row['productDescription']}</td>
                      <td>₹{$row['price']}</td>
                      <td>{$row['quantity']}</td>
                      <td>₹{$subtotal}</td>
                      <td>{$row['mode']}</td>
                    </tr>";
          }
          ?>
          <tr class="total-row">
            <td colspan="4">Total Price</td>
            <td colspan="2">₹<?php echo $total_price; ?></td>
          </tr>
        </tbody>
      </table>

      <!-- Print Button -->
      <button class="print-btn" onclick="printBill()">Print Bill</button>

    </div>
  </main>
</div>

<script defer src="Scripts/get-print.js"></script>

</body>
</html>

<?php include("Includes/footer.php"); ?>
