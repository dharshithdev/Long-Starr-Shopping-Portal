<aside class="w-64 bg-white h-screen shadow-md border-r px-4 py-6">
  <nav class="space-y-2 text-gray-800 text-sm font-medium">
    <!-- Dashboard -->
    <a href="dashboard.php" class="block px-3 py-2 rounded hover:bg-gray-100">
      Dashboard
    </a>

    <!-- Orders Dropdown -->
    <div x-data="{ open: false }" class="space-y-1">
      <button @click="open = !open" class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-gray-100">
        <span>Orders</span>
        <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open" class="pl-5 space-y-1 text-gray-600" x-cloak>
        <a href="todays-order.php" class="block py-1 hover:underline">Today's Orders</a>
        <a href="pending-orders.php" class="block py-1 hover:underline">Pending Orders</a>
        <a href="total-orders.php" class="block py-1 hover:underline">Total Orders</a>
      </div>
    </div>

    <!-- Manage Category -->
    <div x-data="{ open: false }" class="space-y-1">
      <button @click="open = !open" class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-gray-100">
        <span>Manage Category</span>
        <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open" class="pl-5 space-y-1 text-gray-600" x-cloak>
        <a href="create-category.php" class="block py-1 hover:underline">Create Category</a>
        <a href="manage-category.php" class="block py-1 hover:underline">Manage Category</a>
      </div>
    </div>

    <!-- Manage Products -->
    <div x-data="{ open: false }" class="space-y-1">
      <button @click="open = !open" class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-gray-100">
        <span>Manage Products</span>
        <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open" class="pl-5 space-y-1 text-gray-600" x-cloak>
        <a href="insert-product.php" class="block py-1 hover:underline">Insert Products</a>
        <a href="manage-products.php" class="block py-1 hover:underline">Manage Products</a>
        <a href="deleted-products.php" class="block py-1 hover:underline">Deleted Products</a>
      </div>
    </div>

    <!-- Users -->
    <div x-data="{ open: false }" class="space-y-1">
      <button @click="open = !open" class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-gray-100">
        <span>Users</span>
        <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open" class="pl-5 space-y-1 text-gray-600" x-cloak>
        <a href="total-users.php" class="block py-1 hover:underline">Total Users</a>
        <a href="user-log-data.php" class="block py-1 hover:underline">User Logs</a>
      </div>
    </div>

    <!-- Print Details -->
    <div x-data="{ open: false }" class="space-y-1">
      <button @click="open = !open" class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-gray-100">
        <span>Invoices</span>
        <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div x-show="open" class="pl-5 space-y-1 text-gray-600" x-cloak>
        <a href="print-invoice.php" class="block py-1 hover:underline">Print Invoices</a>
      </div>
    </div>
  </nav>
</aside>
