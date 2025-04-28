<?php 
include("Connections/connect.php");
include("Connections/verification.php");
?>
<header class="bg-[#131921] text-white px-4 py-2 w-full fixed top-0 z-50">
  <div class="max-w-screen-xl mx-auto flex items-center justify-between">

    <!-- Logo -->
    <div class="flex items-center space-x-3"> 
      <a href="/longstarr/index.php"><img src="Assets/logo.jpeg" alt="Longstar Logo" class="w-12 h-12 object-contain"></a>
      <span class="text-xl font-bold"><a href="/longstarr/index.php">Longstar</a></span>
    </div>

    <!-- Desktop Search Bar -->
    <div class="hidden sm:flex flex-1 justify-center mx-4">
      <div class="flex w-full max-w-xl">
        <select class="bg-gray-200 text-black text-sm px-2 py-2 rounded-l-md border-r border-gray-400">
          <option>All</option>
        </select>
        <input type="text" placeholder="Search Longstar" class="w-full px-4 py-2 text-black">
        <button class="bg-yellow-400 px-4 py-2 rounded-r-md">
          <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Desktop Icons -->
    <div class="hidden sm:flex space-x-6 items-center">
      <a href="account.php"><img src="Assets/account.png" alt="Account" class="w-6 h-6"></a>
      <a href="wishlist.php"><img src="Assets/wishlist2.png" alt="Wishlist" class="w-6 h-6"></a>
      <a href="cart.php"><img src="Assets/cart3.png" alt="Cart" class="w-6 h-6"></a>
    </div>

    <!-- Mobile Menu Button -->
    <button id="menu-button" class="sm:hidden text-white text-3xl">
      ☰
    </button>
  </div>

  <!-- Mobile Search Bar (Floating, no background) -->
  <div class="sm:hidden px-2 absolute left-0 right-0 top-full mt-1 z-40">
    <div class="flex w-full bg-white rounded-md shadow-md overflow-hidden">
      <select class="text-black text-sm px-2 py-2 rounded-l-md border-r border-gray-400 border bg-transparent">
        <option>All</option>
      </select>
      <input type="text" placeholder="Search Longstar" class="w-full px-4 py-2 text-black border border-l-0 bg-transparent">
      <button class="bg-yellow-400 px-4 py-2 rounded-r-md border">
        <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Slide Menu -->
<div id="mobile-menu" class="fixed top-0 right-0 w-2/3 h-full bg-[#232F3E] p-6 flex flex-col space-y-4 text-white shadow-lg transition-transform transform translate-x-full duration-300 ease-in-out z-50">
  <button id="close-menu" class="text-white text-xl self-end">✖</button>

  <a href="account.php" class="flex items-center space-x-2">
    <img src="Assets/account.png" alt="Account" class="w-6 h-6"> <span>Account</span>
  </a>
  <a href="wishlist.php" class="flex items-center space-x-2">
    <img src="Assets/wishlist2.png" alt="Wishlist" class="w-6 h-6"> <span>Wishlist</span>
  </a>
  <a href="cart.php" class="flex items-center space-x-2">
    <img src="Assets/cart3.png" alt="Cart" class="w-6 h-6"> <span>Cart</span>
  </a>
</div>

<script src="/longstarr/Scripts/header.js"></script>

<!-- Adjust body padding to remove extra gap -->
<style>
  body {
    padding-top: 95px; /* Adjust for fixed header */
  }

  @media (max-width: 640px) {
    body {
      padding-top: 140px; /* Extra for floating mobile search bar */
    }
  }
  
</style>
