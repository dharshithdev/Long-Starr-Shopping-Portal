<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

$sql = "SELECT 
            t.id AS trackId, 
            t.expectedDelivery AS delivery, 
            t.orderStatus AS status, 
            t.updationDate AS updationDate,
            o.quantity, o.mode, o.total, o.creationDate,
            p.id AS productId, 
            p.productName, 
            p.productDescription, 
            p.price 
        FROM trackorder t 
        JOIN orders o ON t.orderId = o.id 
        JOIN products p ON o.productId = p.id
        WHERE t.userId = ?
        ORDER BY o.creationDate DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Assets/icon.png">
    <link rel="stylesheet" href="Styles/styles.css">
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">My Orders</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="space-y-6">
            <?php while ($row = $result->fetch_assoc()):
                $productId = $row['productId'];
                $trackId = $row['trackId'];
                $status = $row['status'];
                $delivery = $row['delivery'];
                $updationDate = $row['updationDate'];
                $imageDir = "Admin/productImages/$productId";
                $imagePath = "Assets/no-image.png";

                if (is_dir($imageDir)) {
                    $files = scandir($imageDir);
                    foreach ($files as $file) {
                        if ($file != "." && $file != "..") {
                            $imagePath = "$imageDir/$file";
                            break;
                        }
                    }
                }
            ?>
            <div class="bg-white rounded-lg shadow-md p-4 flex flex-col sm:flex-row gap-4 sm:gap-6 items-center">
                <img src="<?php echo $imagePath; ?>" alt="Product Image" class="w-32 h-32 object-cover rounded-md border" />
                
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($row['productName']);?></h2>
                    <h2 class="text-xl font-semibold mt-1">
                        Status:
                        <span class="<?php 
                            echo $status === 'Cancelled' ? 'text-red-600' : ($status === 'Delivered' ? 'text-green-600' : '');
                        ?>">
                        <?php echo htmlspecialchars($status); ?>
                        </span>
                    </h2>

                    <?php if ($status !== 'Cancelled'): ?>
                        <p class="text-xl font-semibold mt-1">
                            Expected Delivery By: <?php echo htmlspecialchars($delivery); ?>
                        </p>
                    <?php else: ?>
                        <p class="text-xl font-semibold mt-1">
                            Cancelled on: <?php echo htmlspecialchars($updationDate); ?>
                        </p>
                    <?php endif; ?>

                    <p class="text-green-600 mt-2 font-bold text-lg">Total: ₹<?php echo $row['total']; ?></p>

                    <!-- Buttons -->
                    <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center sm:justify-start w-full">
                        <!-- Cancel Button -->
                        <form class="w-full sm:w-auto">
                            <?php if ($status !== 'Cancelled'): ?>
                                <button 
                                    type="button" 
                                    onclick="openPopup(<?php echo $trackId; ?>)" 
                                    class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-center">
                                    Cancel Order
                                </button>
                            <?php else: ?>
                                <button 
                                    disabled 
                                    class="w-full sm:w-auto bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed opacity-70 text-center">
                                    Cancelled
                                </button>
                            <?php endif; ?>
                        </form>

                        <!-- Buy Again Button -->
                        <form class="w-full sm:w-auto">
                            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                            <button 
                                type="submit" 
                                onclick="redirectToOrder(<?php echo $productId; ?>, this)" 
                                class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center">
                                Buy Again
                            </button>
                        </form>

                        <form method="post" class="w-full sm:w-auto" action="order-details.php">
                            <input type="hidden" name="trackingId" value="<?php echo $trackId; ?>">
                            <button 
                                type="submit" 
                                class="w-full sm:w-auto bg-blue-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center">
                                Details
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-600">You don't have any orders yet.</p>
    <?php endif; ?>
</div>

<!-- Popup Modal -->
<div id="cancelPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-sm">
    <p class="mb-4 text-lg font-semibold">Are you sure you want to cancel this order?</p>
    <form method="POST" action="Logics/cancel-item.php">
      <input type="hidden" name="trackId" id="popupTrackId">
      <div class="flex justify-center gap-4 mt-4">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded w-24">Yes</button>
        <button type="button" onclick="closePopup()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded w-24">No</button>
      </div>
    </form>
  </div>
</div>

<script src="/longstarr/Scripts/view-orders.js"></script>

</body>
</html>
<?php //include("Includes/footer.php"); ?>