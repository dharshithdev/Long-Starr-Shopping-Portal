<?php
session_start();
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$userName = $user['username'];

$_SESSION['user_id'] = $userId;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="icon" type="image/png" href="Assets/icon.png">
    <link href="Styles/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

<div class="w-full px-4 py-6 sm:py-10 flex justify-center">
  <div class="flex flex-col items-center w-full max-w-screen-lg">

    <!-- Welcome Section -->
    <div class="bg-white p-8 sm:p-12 rounded-xl shadow w-full text-center mb-6">
      <h3 class="text-xl sm:text-2xl font-bold mb-4">Welcome, <?php echo $userName ?? 'User'; ?> 👋</h3>
      <p class="text-base sm:text-lg text-gray-600">Manage your account settings and view order details here.</p>
    </div>

    <!-- Action Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full px-2 sm:px-0">
      
      <!-- Change Password -->
      <div class="bg-white p-6 sm:p-10 rounded-xl shadow hover:shadow-md transition w-full text-center">
        <h4 class="text-lg sm:text-xl font-semibold mb-2">📋 Change Details</h4>
        <a href="change-details.php" class="text-blue-600 sm:text-lg font-semibold hover:underline">Change Details</a>
      </div>

      <!-- Update Address -->
      <div class="bg-white p-6 sm:p-10 rounded-xl shadow hover:shadow-md transition w-full text-center">
        <h4 class="text-lg sm:text-xl font-semibold mb-2">🔒 Change Password</h4>
        <a href="change-password.php" class="text-blue-600 sm:text-lg font-semibold hover:underline">Change Password</a>
      </div>

      <!-- Track Orders -->
      <div class="bg-white p-6 sm:p-10 rounded-xl shadow hover:shadow-md transition w-full text-center">
        <h4 class="text-lg sm:text-xl font-semibold mb-2">🏠 Change Address</h4>
        <a href="change-address.php" class="text-blue-600 sm:text-lg font-semibold hover:underline">Change Address</a>
      </div>

      <!-- Past Orders -->
      <div class="bg-white p-6 sm:p-10 rounded-xl shadow hover:shadow-md transition w-full text-center">
        <h4 class="text-lg sm:text-xl font-semibold mb-2">🚚 Track Order</h4>
        <a href="view-orders.php" class="text-blue-600 sm:text-lg font-semibold hover:underline">View Orders</a>
      </div>

      <!-- Log Out -->
      <div class="bg-white p-6 sm:p-10 rounded-xl shadow hover:shadow-md transition w-full text-center">
        <h4 class="text-lg sm:text-xl font-semibold mb-2">🚪 Log Out</h4>
        <a href="Logics/log-out.php" class="text-red-600 sm:text-lg font-semibold hover:underline">Log Out</a>
      </div>

      <!-- Delete Account -->
      <div class="bg-white p-6 sm:p-10 rounded-xl shadow hover:shadow-md transition w-full text-center">
        <h4 class="text-lg sm:text-xl font-semibold mb-2">🗑️ Delete Account</h4>
        <a href="delete-account.php" class="text-red-600 sm:text-lg font-semibold hover:underline">Delete</a>
      </div>

    </div>

  </div>
</div>

</body>
</html>
<?php include("Includes/footer.php"); ?>