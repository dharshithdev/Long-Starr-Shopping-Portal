<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

$sql = "SELECT w.id AS wishlistId, p.id AS productId, p.productName, p.productDescription, p.price 
        FROM wishlist w 
        JOIN products p ON w.productId = p.id 
        WHERE w.userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Wishlist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/styles.css">
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">My Wishlist</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="space-y-6">
            <?php while ($row = $result->fetch_assoc()):
                $productId = $row['productId'];
                $wishlistId = $row['wishlistId'];
                $imageDir = "Admin/productImages/$productId";
                $imagePath = "Assets/no-image.png"; //

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
                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($row['productName']); ?></h2>
                    <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($row['productDescription']); ?></p>
                    <p class="text-green-600 mt-2 font-bold text-lg">₹<?php echo $row['price']; ?></p>

                    <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center sm:justify-start">
                        <form method="POST" action="Logics/add-to-cart.php">
                            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full sm:w-auto">Add to Cart</button>
                        </form>

                        <form method="POST" action="Logics/remove-from-wishlist.php">
                            <input type="hidden" name="wishlistId" value="<?php echo $wishlistId; ?>">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded w-full sm:w-auto">Remove</button>
                        </form>

                        <form>
                            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                            <button type="submit" id="buy-now-button" onclick="redirectToOrder(<?php echo $productId; ?>, this)" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full sm:w-auto">Buy Now</button>
                        </form> 
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-600">Your wishlist is empty.</p>
    <?php endif; ?>
</div>
 <script src="/longstarr/Scripts/wishlist.js"></script>
</body>
</html>
