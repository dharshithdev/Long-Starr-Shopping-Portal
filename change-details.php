<?php
session_start();
include("Connections/connect.php");
include("Connections/authorization.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phoneNumber'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phoneNumber = ?, updationDate = NOW() WHERE id = ?");
    $stmt->bind_param("sssi", $newUsername, $newEmail, $newPhone, $userId);

    if ($stmt->execute()) {
        $message = "Details updated successfully!";
    } else {
        $message = "Something went wrong. Please try again.";
    }

    $stmt->close();
}

    // Fetch user data
    $stmt = $conn->prepare("SELECT username, email, phoneNumber FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Styles/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

    <?php include("Includes/simple-header.php"); ?> <!-- ✅ Moved inside body after head -->

    <div class="flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white shadow-md rounded-xl p-6 sm:p-8 md:p-10 mt-6 sm:mt-10">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-gray-800">Update Your Details</h2>

            <?php if (!empty($message)): ?>
                <div class="mb-4 text-center text-green-600 font-semibold text-sm sm:text-base">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-base">Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="w-full px-4 py-2 text-sm sm:text-base border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-base">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full px-4 py-2 text-sm sm:text-base border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-base">Phone Number</label>
                    <input type="text" name="phoneNumber" value="<?= htmlspecialchars($user['phoneNumber']) ?>" class="w-full px-4 py-2 text-sm sm:text-base border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 text-sm sm:text-base rounded-md hover:bg-blue-700 transition">
                        Change Details
                    </button>
                </div>              
            </form>
        </div>
    </div>
</body>
</html>
<?php include("Includes/footer.php"); ?>