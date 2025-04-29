<?php
session_start();
include("Connections/connect.php");
include("Connections/authorization.php");

$message = "";
$error = "";

// Fetch the current password from database
$stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (password_verify($currentPassword, $user['password'])) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashedPassword, $adminId);

            if ($stmt->execute()) {
                $message = "Password updated successfully!";
            } else {
                $error = "Something went wrong. Please try again.";
            }

            $stmt->close();
        } else {
            $error = "New passwords do not match.";
        }
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Styles/styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="Assets/icon.png">
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <?php include("Includes/header.php"); ?>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64">
            <?php include("Includes/side-bar.php"); ?>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-6 sm:p-10 md:p-12 flex items-start justify-center">
            <div class="w-full max-w-md bg-white shadow-md rounded-xl p-6 sm:p-8 md:p-10 mt-4 space-y-6">

                <h2 class="text-2xl font-bold text-center text-gray-800">Update Password</h2>

                <!-- Show message -->
        <!-- Show success message -->
        <?php if (!empty($message)) { ?>
            <div class="p-4 mb-4 text-sm text-white bg-green-600 rounded-lg text-center font-semibold">
                <?php echo $message; ?>
            </div>
        <?php } ?>
        
        <!-- Show error message -->
        <?php if (!empty($error)) { ?>
            <div class="p-4 mb-4 text-sm text-white bg-red-600 rounded-lg text-center font-semibold">
                <?php echo $error; ?>
            </div>
        <?php } ?>


                <form method="post" action="update-password.php" class="space-y-4">
                    <div>
                        <label class="block text-gray-700">Current Password</label>
                        <input type="password" name="currentPassword" required class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">New Password</label>
                        <input type="password" name="newPassword" required class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div>
                        <label class="block text-gray-700">Confirm New Password</label>
                        <input type="password" name="confirmPassword" required class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div>
                        <button type="submit" class="w-full py-3 px-4 rounded-md bg-blue-600 hover:bg-green-700 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-green-400 transition ease-in-out duration-150">
                            Update Password
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php include("Includes/footer.php"); ?>

</body>
</html>
