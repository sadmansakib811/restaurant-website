<?php
// profile.php - Customer profile page
session_start();
require 'db.php';

// Check if customer is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user']; // Assuming this contains the customer's data
$message = '';

// Process profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    // In production, validate inputs and consider password changes with proper hashing
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    if ($stmt->execute([$username, $email, $user['id']])) {
        $message = "Profile updated successfully!";
        // Update session data
        $user['username'] = $username;
        $user['email'] = $email;
        $_SESSION['user'] = $user;
    } else {
        $message = "Profile update failed.";
    }
}

// Fetch customer orders (assuming an orders table exists with user_id, total, payment_method, status, created_at columns)
$orderStmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$orderStmt->execute([$user['id']]);
$orders = $orderStmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="container mx-auto py-4">
  <h1 class="text-3xl font-bold mb-4">My Profile</h1>
  
  <?php if ($message): ?>
    <div class="alert alert-info"><?php echo $message; ?></div>
  <?php endif; ?>
  
  <div class="card p-4 mb-8 shadow">
    <h2 class="text-2xl font-bold mb-2">Update Profile</h2>
    <form method="post" class="space-y-4">
      <input type="hidden" name="update_profile" value="1">
      <div>
        <label class="label">Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required class="input input-bordered w-full">
      </div>
      <div>
        <label class="label">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="input input-bordered w-full">
      </div>
      <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
  </div>
  
  <div class="card p-4 shadow">
    <h2 class="text-2xl font-bold mb-4">My Orders</h2>
    <?php if(empty($orders)): ?>
      <p>You have not placed any orders yet.</p>
    <?php else: ?>
      <table class="table w-full">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Total</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Placed At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $order): ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td>$<?php echo number_format($order['total'], 2); ?></td>
            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
            <td><?php echo htmlspecialchars($order['status']); ?></td>
            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
            <td>
              <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">View</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
