<?php
include('Connections/connect.php');
session_start();

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Prepare statement to fetch user data securely
  $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email); 
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];
 
    // Verify password
    if (password_verify($password, $hashedPassword)) {
      $_SESSION['user_id'] = $row['id'];
      include("Connections/set-cookie.php");

      $userId = $row['id'];
      $log = $conn->prepare("INSERT INTO userlogs (userId) VALUES (?)");
      $log->bind_param("i", $userId);
      $log->execute();

      header("Location: index.php");
      exit();
    } else {
      $msg = "Invalid email or password!";
    }
  } else {
    $msg = "Invalid email or password!";
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Log In - Longstar</title>
  <link rel="icon" href="Assets/logo.ico" type="image/x-icon" />
  <link rel="stylesheet" href="Styles/styles.css">
</head>
<body class="bg-white min-h-screen flex items-center justify-center">

  <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300 w-full max-w-xs sm:max-w-sm min-h-[450px] space-y-6">
    <div class="flex justify-center">
      <img src="Assets/logo.jpeg" alt="Logo" class="w-8 h-8">
    </div>
    <h2 class="text-xl font-bold text-center text-blue-700">Log In</h2>

    <?php if ($msg): ?>
      <p class="text-red-500 text-center text-sm"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4 text-sm">
      <input type="email" name="email" placeholder="Email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700 transition-all">
        Log In
      </button>
    </form>

    <p class="text-xs text-center text-gray-600">Don't have an account? 
      <a href="register.php" class="text-blue-600 hover:underline">Sign Up</a>
    </p>
  </div>

</body>
</html>
