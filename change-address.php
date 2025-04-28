<?php
session_start();
include("Connections/connect.php");
include("Connections/authorization.php");
    
$message = "";

    // Fetch user data
    $stmt = $conn->prepare("SELECT state, pinCode, address FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newState = $_POST['newState'];
    $newPinCode = $_POST['newPinCode'];
    $newAddress = $_POST['newAddress'];

    $stmt = $conn->prepare("UPDATE users SET state = ?, pinCode = ?, address = ? WHERE id = ?");
    $stmt->bind_param("sssi", $newState, $newPinCode, $newAddress, $userId);

    if ($stmt->execute()) {
        $message = "Address updated successfully!";
    } else {
        $message = "Something went wrong. Please try again.";
    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change <Address></Address></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Styles/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

    <?php include("Includes/simple-header.php"); ?> <!-- ✅ Moved inside body after head -->

    <div class="flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white shadow-md rounded-xl p-6 sm:p-8 md:p-10 mt-6 sm:mt-10">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-gray-800">Update Your Address</h2>

            <?php if (!empty($message)): ?>
                <div class="mb-4 text-center text-green-600 font-semibold text-sm sm:text-base">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-base">State</label>
                    <input type="text" name="newState" value="<?= htmlspecialchars($user['state']) ?>" class="w-full px-4 py-2 text-sm sm:text-base border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-base">Pin Code</label>
                    <input type="text" name="newPinCode" value="<?= htmlspecialchars($user['pinCode']) ?>" class="w-full px-4 py-2 text-sm sm:text-base border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-base">House Address</label>
                    <input type="text" name="newAddress" value="<?= htmlspecialchars($user['address']) ?>" class="w-full px-4 py-2 text-sm sm:text-base border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 text-sm sm:text-base rounded-md hover:bg-blue-700 transition">
                        Change Address
                    </button>
                </div>              
            </form>
        </div>
    </div>
</body>
</html>
<?php include("Includes/footer.php"); ?>