<?php
session_start();
include("Connections/connect.php"); // Adjust path to your DB connection file

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_id'] = $admin['id'];
            $adminId = $_SESSION['admin_id'];
            $in = "In";

            $stmt = $conn->prepare("INSERT INTO adminlogs (adminId, logInTime, logOutTime) VALUES (?, NOW(), ?)");
            $stmt->bind_param("is", $adminId, $in);
            $stmt->execute();

            header("Location: home.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="icon" type="image/png" href="Assets/icon.png">
    <link href="../Styles/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-semibold text-center mb-6">Admin Login</h2>

        <?php if ($error): ?>
            <div class="mb-4 text-red-600 text-sm text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Username</label>
                <input type="text" name="username" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block mb-1 text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
        </form>
    </div>
</body>
</html>
