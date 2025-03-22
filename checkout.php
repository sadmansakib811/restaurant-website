<?php
// checkout.php - Payment & Order Completion Page

session_start();

// Load Composer autoloader (this will load Dotenv and Stripe libraries)
require 'vendor/autoload.php';

// Load database connection
require 'db.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$stripeSecret = $_ENV['STRIPE_SECRET_KEY'];

// Calculate cart total (assumes $_SESSION['cart'] contains product_id => quantity)
$cart_total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM food_items WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $foods = $stmt->fetchAll();

    foreach ($foods as $food) {
        $quantity = $_SESSION['cart'][$food['id']];
        $cart_total += $food['price'] * $quantity;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

    // Decide on initial statuses
    // - payment_status: track payment progress (e.g. "Pending Payment", "Paid")
    // - order_status: track order acceptance/cancellation (e.g. "Pending", "Accepted", "Cancelled")
    if ($payment_method === 'stripe') {
        $payment_status = 'Pending Payment';
        $order_status   = 'Pending';
    } else {
        // For Cash on Delivery
        $payment_status = 'Unpaid';  // or "COD" – up to you
        $order_status   = 'Pending';
    }

    // Insert a new order record (assuming your orders table has columns:
    // id, user_id, total, payment_method, payment_status, order_status, created_at, etc.)
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, payment_method, payment_status, order_status) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $cart_total, $payment_method, $payment_status, $order_status]);
    $order_id = $pdo->lastInsertId();

    if ($payment_method === 'stripe') {
        // Stripe payment processing using the secret key from the environment variable
        \Stripe\Stripe::setApiKey($stripeSecret);

        // Create a Stripe Checkout Session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Restaurant Order #' . $order_id,
                    ],
                    'unit_amount' => intval($cart_total * 100), // Amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:8080/success.php?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order_id,

            'cancel_url' => 'http://localhost:8080/restaurant-website/cancel.php',
        ]);

        // Redirect to Stripe Checkout page
        header("Location: " . $session->url);
        exit;
    } else {
        // For Cash on Delivery, clear cart and redirect to success page
        unset($_SESSION['cart']);
        header("Location: success.php?order_id=" . $order_id);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="container mx-auto py-4">
    <h1 class="text-3xl font-bold mb-4">Checkout</h1>
    <p class="mb-4">Total Amount: $<?php echo number_format($cart_total, 2); ?></p>
    <?php if ($cart_total <= 0): ?>
        <p>Your cart is empty. <a href="index.php" class="btn btn-primary">Go back</a></p>
    <?php else: ?>
        <form method="post" class="space-y-4">
            <div>
                <label class="label">Select Payment Method:</label>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="label-text">Stripe Payment</span>
                        <input type="radio" name="payment_method" value="stripe" class="radio" required>
                    </label>
                    <label class="cursor-pointer label">
                        <span class="label-text">Cash on Delivery</span>
                        <input type="radio" name="payment_method" value="cod" class="radio" required>
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
