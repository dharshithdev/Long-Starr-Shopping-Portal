<?php 
include("Connections/connect.php");
include("Connections/verification.php");
?>
<header class="bg-[#131921] text-white px-4 py-3 w-full fixed top-0 z-50 shadow-md">
  <div class="max-w-screen-xl mx-auto flex items-center justify-between">

    <!-- Logo + Brand Name -->
    <div class="flex items-center space-x-3">
      <img src="Assets/logo.jpeg" alt="Longstar Logo" class="w-10 h-10 object-contain">
      <span class="text-lg sm:text-xl font-bold"><a href="/longstarr/index.php">Longstar</a></span> 
    </div>

    <!-- Desktop Icons (Hidden on mobile) -->
    <div class="hidden sm:flex items-center space-x-6">
      <a href="account.php" title="Account"><img src="Assets/account.png" alt="Account" class="w-6 h-6"></a>
      <a href="wishlist.php" title="Wishlist"><img src="Assets/wishlist2.png" alt="Wishlist" class="w-6 h-6"></a>
      <a href="cart.php" title="Cart"><img src="Assets/cart3.png" alt="Cart" class="w-6 h-6"></a>
    </div>

    <!-- Mobile Menu Button -->
    <button id="menu-button" class="sm:hidden text-white text-3xl focus:outline-none">
      ☰
    </button>
  </div>

  <!-- Mobile Slide Menu -->
  <div id="mobile-menu" class="fixed top-0 right-0 w-3/4 max-w-xs h-full bg-[#232F3E] p-6 flex flex-col space-y-5 text-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <!-- Close Button -->
    <button id="close-menu" class="text-white text-2xl self-end hover:text-gray-300">✖</button>

    <!-- Mobile Nav Links -->
    <nav class="mt-8 space-y-5">
      <a href="account.php" class="flex items-center space-x-3 hover:text-gray-300">
        <img src="Assets/account.png" alt="Account" class="w-6 h-6"> <span class="text-lg">Account</span>
      </a>
      <a href="wishlist.php" class="flex items-center space-x-3 hover:text-gray-300">
        <img src="Assets/wishlist2.png" alt="Wishlist" class="w-6 h-6"> <span class="text-lg">Wishlist</span>
      </a>
      <a href="cart.php" class="flex items-center space-x-3 hover:text-gray-300">
        <img src="Assets/cart3.png" alt="Cart" class="w-6 h-6"> <span class="text-lg">Cart</span>
      </a>
    </nav>
  </div>
</header>

<!-- JS to toggle mobile menu -->
<script src="/longstarr/Scripts/simple-header.js"></script>

<!-- Body Padding (to avoid content being hidden under fixed header) -->
<style>
  body {
    padding-top: 80px;
  }

  @media (max-width: 640px) {
    body {
      padding-top: 110px;
    }
  }
</style>
