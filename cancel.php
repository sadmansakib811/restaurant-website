<?php
// cancel.php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Cancelled</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container mx-auto py-4">
    <h1 class="text-3xl font-bold mb-4">Order Cancelled</h1>
    <p>Your payment was cancelled. Please try again or choose a different payment method.</p>
    <a href="checkout.php" class="btn btn-primary mt-4">Return to Checkout</a>
</div>
</body>
</html>
