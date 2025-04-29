<?php
include('Connections/connect.php');
session_start();

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $phone = $_POST["phone"];
  $email = $_POST["email"];
  $gender = $_POST["gender"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirm_password"];

  $query = $conn->prepare("SELECT * from users WHERE email = ?");
  $query->bind_param("s", $email);
  $query->execute();
  $res = $query->get_result();
  if ($res->num_rows > 0) {
    $msg = "Email already registered!"; 
  } else {
    if ($password !== $confirmPassword) {
        $msg = "Passwords do not match!";
      } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, phoneNumber, email, gender, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $phone, $email, $gender, $hashedPassword);
    
        if ($stmt->execute()) {
          $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
          $_SESSION['user_id'] = $row['id'];
          include("Connections/set-cookie.php");
          $userId = $row['id'];

          $log = $conn->prepare("INSERT INTO userlogs (userId) VALUES (?)");
          $log->bind_param("i", $userId);
          $log->execute();

          header("Location: index.php");
          exit();
        } else {
          $msg = "Error: " . $stmt->error;
        }
      }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up - Longstar</title>
  <link rel="icon" href="Assets/logo.jpeg" type="image/x-icon" />
  <link rel="icon" type="image/png" href="Assets/icon.png">
  <link rel="stylesheet" href="Styles/styles.css">
</head>
<body class="bg-white min-h-screen flex items-center justify-center">

  <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-300 w-full max-w-sm sm:max-w-md">
    <div class="flex justify-center mb-4">
      <img src="Assets/logo.ico" alt="Logo" class="w-10 h-10">
    </div>
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-2">Create Account</h2>

    <?php if ($msg): ?>
      <p class="text-red-500 text-center text-sm mb-3"><?= $msg ?></p>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-3 text-sm">
      <input type="text" name="username" placeholder="Full Name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      
      <input type="text" name="phone" placeholder="Phone Number" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      
      <input type="email" name="email" placeholder="Email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      
      <select name="gender" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="" disabled selected>Select Gender</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>

      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>

      <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700 transition-all">
        Register
      </button>
    </form>

    <p class="text-xs text-center text-gray-600 mt-3">Already have an account? 
      <a href="login.php" class="text-blue-600 hover:underline">Log in</a>
    </p>
  </div>

</body>
</html>
