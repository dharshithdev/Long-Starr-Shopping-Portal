<?php
include("Connections/authorization.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link href="../Styles/styles.css" rel="stylesheet">
  <script src="Scripts/cdn.min.js" defer></script>
</head>
<body>
<header class="bg-white border-b shadow-sm px-6 py-3 flex items-center justify-between">
  
  <!-- Logo + Company Name -->
  <div class="flex items-center gap-3">
    <img src="Assets/logo.jpeg" alt="Longstar Logo" class="h-10 w-10 object-contain rounded-full" />
    <span class="text-2xl font-semibold text-gray-800 tracking-wide">Longstar</span>
  </div>

  <!-- Navigation -->
  <nav class="hidden md:flex items-center gap-6 text-sm text-gray-700">
    <a href="dashboard.php" class="hover:text-blue-600 font-medium">Dashboard</a>
    <a href="../index.php" class="hover:text-blue-600 font-medium">Longstarr</a>
    <a href="settings.php" class="hover:text-blue-600 font-medium">Settings</a>
  </nav>

  <!-- Profile -->
  <div class="flex items-center gap-3">
    <span class="hidden md:inline text-sm text-gray-600">Admin</span>
    <img src="Assets/admin.jpeg" alt="Admin Profile" class="h-9 w-9 rounded-full object-cover border border-gray-300 shadow-sm" />
  </div>
</header>
