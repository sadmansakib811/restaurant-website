<?php
// reservation.php - Table reservation form

require 'db.php';
include 'navbar.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize inputs
    $name  = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $date  = htmlspecialchars(trim($_POST['date']));
    $time  = htmlspecialchars(trim($_POST['time']));
    
    // Insert reservation into the database
    $stmt = $pdo->prepare("INSERT INTO reservations (name, email, phone, reservation_date, reservation_time) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $phone, $date, $time])) {
        $message = "Reservation successful!";
    } else {
        $message = "Reservation failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Table Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Table Reservation</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-4">
            <div>
                <label class="label">Name</label>
                <input type="text" name="name" required class="input input-bordered w-full">
            </div>
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" required class="input input-bordered w-full">
            </div>
            <div>
                <label class="label">Phone</label>
                <input type="text" name="phone" required class="input input-bordered w-full">
            </div>
            <div>
                <label class="label">Date</label>
                <input type="date" name="date" required class="input input-bordered w-full">
            </div>
            <div>
                <label class="label">Time</label>
                <input type="time" name="time" required class="input input-bordered w-full">
            </div>
            <button type="submit" class="btn btn-primary">Reserve</button>
        </form>
    </div>
</body>
</html>
