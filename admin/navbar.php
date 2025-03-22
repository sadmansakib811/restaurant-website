<!-- admin/navbar.php -->
<nav class="navbar bg-base-100 shadow-sm px-4">
  <!-- Left side: Admin Panel Title -->
  <div class="flex-1">
    <a href="dashboard.php" class="btn btn-ghost normal-case text-xl">
      Admin Panel
    </a>
  </div>

  <!-- Right side: Navigation Links and User Dropdown -->
  <div class="flex-none gap-2">
    <!-- Horizontal Menu for Larger Screens -->
    <ul class="menu menu-horizontal p-0 hidden lg:flex">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="orders.php">Orders</a></li>
      <li><a href="customers.php">Customers</a></li>
      <li><a href="reservations.php">Reservations</a></li>
      <li><a href="products.php">Products</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>

    <!-- User Dropdown (Avatar) -->
    <div class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <!-- Use a default avatar image or load the admin's profile picture dynamically -->
          <img src="https://img.daisyui.com/avatars/blank.png" alt="Admin Avatar" />
        </div>
      </label>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
