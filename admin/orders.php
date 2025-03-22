<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../db.php';


// Process order actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);

    // If your 'orders' table has columns 'order_status' and 'payment_status', 
    // then update 'order_status' here, not just 'status'.
    if (isset($_POST['accept'])) {
        // Update order_status to "Accepted"
        $stmt = $pdo->prepare("UPDATE orders SET order_status = 'Accepted' WHERE id = ?");
        $stmt->execute([$order_id]);
    } elseif (isset($_POST['cancel'])) {
        // Update order_status to "Cancelled"
        $stmt = $pdo->prepare("UPDATE orders SET order_status = 'Cancelled' WHERE id = ?");
        $stmt->execute([$order_id]);
    } elseif (isset($_POST['delete'])) {
        // Delete the order record (order_items should cascade if set up)
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
    }
    header("Location: orders.php");
    
    exit;
 
}
include 'navbar.php';
// Retrieve all orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Orders Management</h1>
        <?php if (empty($orders)): ?>
            <p>No orders found.</p>
        <?php else: ?>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['user_id'] ?: 'Guest'; ?></td>
                        <td>$<?php echo number_format($order['total'], 2); ?></td>
                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                        <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                        <td>
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <?php if ($order['order_status'] !== 'Accepted'): ?>
                                    <button type="submit" name="accept" class="btn btn-sm btn-success">Accept</button>
                                <?php endif; ?>
                                <?php if ($order['order_status'] !== 'Cancelled'): ?>
                                    <button type="submit" name="cancel" class="btn btn-sm btn-warning">Cancel</button>
                                <?php endif; ?>
                                <button type="submit" name="delete" class="btn btn-sm btn-error"
                                        onclick="return confirm('Are you sure you want to delete this order?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
