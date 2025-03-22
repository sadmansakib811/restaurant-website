<?php
// admin/customers.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../db.php';
include 'navbar.php';

// Fetch all customers (registered users)
$customersStmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$customers = $customersStmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Customers Management</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
  <div class="container mx-auto py-4">
    <h1 class="text-3xl font-bold mb-4">Customers</h1>
    <?php if(empty($customers)): ?>
      <p>No customers found.</p>
    <?php else: ?>
      <table class="table w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Reservations</th>
            <th>Orders</th>
            <th>Registered At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($customers as $customer): ?>
            <?php
              // Count reservations based on customer's email (from the reservations table)
              $resStmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE email = ?");
              $resStmt->execute([$customer['email']]);
              $reservationCount = $resStmt->fetchColumn();

              // Count orders if an orders table exists (assuming orders table has a user_id field)
              $orderCount = 0;
              try {
                  $orderStmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
                  $orderStmt->execute([$customer['id']]);
                  $orderCount = $orderStmt->fetchColumn();
              } catch (Exception $e) {
                  // If the orders table does not exist, display N/A
                  $orderCount = "N/A";
              }
            ?>
            <tr>
              <td><?php echo $customer['id']; ?></td>
              <td><?php echo htmlspecialchars($customer['username']); ?></td>
              <td><?php echo htmlspecialchars($customer['email']); ?></td>
              <td><?php echo $reservationCount; ?></td>
              <td><?php echo $orderCount; ?></td>
              <td><?php echo htmlspecialchars($customer['created_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
