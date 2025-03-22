<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../db.php';
include 'navbar.php';

$message = '';

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real application, you would update the admin details in your database.
    $new_password = trim($_POST['password']);
    if ($new_password) {
        // Simulate a successful password update.
        // You would normally hash the password and update the admins table.
        $message = "Profile updated successfully (simulation).";
    } else {
        $message = "Please enter a new password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Admin Profile</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="card shadow-lg p-4">
            <p><strong>Username:</strong> admin</p>
            <!-- More profile info can be added here if needed -->
            <form method="post" class="space-y-4 mt-4">
                <div>
                    <label class="label">Change Password</label>
                    <input type="password" name="password" placeholder="Enter new password" class="input input-bordered w-full">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
