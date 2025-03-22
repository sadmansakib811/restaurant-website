<nav class="navbar bg-base-100 shadow-sm px-4">
  <!-- Left side: Logo / Brand -->
  <div class="flex-1">
    <a href="index.php" class="btn btn-ghost normal-case text-xl">
      My Restaurant
    </a>
  </div>
  
  <!-- Right side: Menu items -->
  <div class="flex-none gap-2">
    <!-- Simple nav links (Home, Menu, Reservation) -->
    <ul class="menu menu-horizontal p-0 hidden lg:flex">
      <li><a href="index.php">Home</a></li>
      <li><a href="index.php">Menu</a></li>
      <li><a href="reservation.php">Reservation</a></li>
    </ul>
    
    <!-- Cart dropdown -->
    <div class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle">
        <div class="indicator">
          <!-- Cart Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293
                  2.293c-.63.63-.184 1.707.707 1.707H17m0
                  0a2 2 0 100 4 2 2 0 000-4zm-8
                  2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <!-- Show cart count if available -->
          <span class="badge badge-sm indicator-item">
            <?php
              echo isset($_SESSION['cart']) 
                   ? array_sum($_SESSION['cart']) 
                   : 0;
            ?>
          </span>
        </div>
      </label>
      <div tabindex="0" class="card card-compact dropdown-content w-52 bg-base-100 shadow">
        <div class="card-body">
          <span class="text-lg font-bold">
            Cart Items:
            <?php
              echo isset($_SESSION['cart']) 
                   ? array_sum($_SESSION['cart']) 
                   : 0;
            ?>
          </span>
          <!-- Subtotal or other cart info could go here -->
          <span class="text-info">Subtotal: $XYZ</span>
          <div class="card-actions">
            <a href="cart.php" class="btn btn-primary btn-block">View cart</a>
          </div>
        </div>
      </div>
    </div>

    <!-- User dropdown (username/profile/login) -->
    <?php if (!empty($_SESSION['user'])): ?>
      <!-- If user is logged in, show their username -->
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost normal-case">
          <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
          <!-- Optional small arrow icon -->
          <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
          </svg>
        </label>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li><a href="profile.php">Profile</a></li>
          <li><a href="#">Settings</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    <?php else: ?>
      <!-- If user is not logged in -->
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost normal-case">
          Guest
          <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
          </svg>
        </label>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</nav>