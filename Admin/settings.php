<?php
session_start();
include("Connections/connect.php");
include("Connections/authorization.php");

$message = "";
$error = "";

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

    if(password_verify($currentPassword, $user['password'])) {
        if($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashedPassword,$adminId);
        
            if ($stmt->execute()) {
                $message = "Password updated successfully!";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        
            $stmt->close();
        } else {
            $error = "Password does not Match";
        }
    } else {
        $error = "Current Password is Wrong";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Styles/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header included at top -->
    <?php include("Includes/header.php") ?>

    <div class="flex">
        <!-- Sidebar on the left -->
        <div class="w-64">
            <?php include("Includes/side-bar.php") ?>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-6 sm:p-10 md:p-12 flex items-start justify-center">
            <div class="w-full max-w-md bg-white shadow-md rounded-xl p-6 sm:p-8 md:p-10 mt-4 space-y-4">
                <button onclick="" class="w-full py-3 px-4 rounded-md bg-green-600 hover:bg-indigo-700 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update Password</button>
                <button class="w-full py-3 px-4 rounded-md bg-green-600 hover:bg-indigo-700 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Admin Logs</button>
                <button class="w-full py-3 px-4 rounded-md bg-red-500 hover:bg-red-600 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition ease-in-out duration-150">Log Out</button>
             </div>
        </div>
    </div>

    <?php include("Includes/footer.php"); ?>
</body>
<script>
    function reDirectTo () {
        window.location.href = ""
    }
</script>
</html>
<?php include("Includes/footer.php"); ?>