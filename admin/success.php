<?php
session_start();
// Empty the cart after successful Stripe checkout
//unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="container mx-auto py-4">
    <h1 class="text-3xl font-bold mb-4">Order Accepted Successful!</h1>
    <p>Your Customer order has been Accepted successfully.</p>
    <a href="dashboard.php" class="btn btn-primary mt-4">Return to Home</a>
</div>
</body>
</html>
