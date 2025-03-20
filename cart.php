<?php
// cart.php - Handle cart operations and display the cart

session_start();
require 'db.php';

// Add item to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $food_id = intval($_POST['food_id']);

    // Initialize cart if it does not exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Increment quantity if already in cart, otherwise add it
    if (isset($_SESSION['cart'][$food_id])) {
        $_SESSION['cart'][$food_id]++;
    } else {
        $_SESSION['cart'][$food_id] = 1;
    }
    header('Location: cart.php');
    exit;
}

// Remove item from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $food_id = intval($_POST['food_id']);
    unset($_SESSION['cart'][$food_id]);
    header('Location: cart.php');
    exit;
}

// Retrieve food items for those in the cart
$cart_items = [];
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM food_items WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $cart_items = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Your Cart</h1>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart_items as $item):
                        $quantity = $_SESSION['cart'][$item['id']];
                        $subtotal = $item['price'] * $quantity;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="food_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="remove" class="btn btn-error btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-right font-bold">Total</td>
                        <td colspan="2" class="font-bold">$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
            <button class="btn btn-primary">Checkout</button>
        </div>
    </div>
</body>
</html>