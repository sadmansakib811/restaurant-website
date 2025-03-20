<?php
// admin/login.php - Admin login page
session_start();


$admin_username = 'admin';
$admin_password = 'admin123';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Admin Login</h1>
        <?php if ($message): ?>
            <div class="alert alert-error"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-4">
            <div>
                <label class="label">Username</label>
                <input type="text" name="username" required class="input input-bordered w-full">
            </div>
            <div>
                <label class="label">Password</label>
                <input type="password" name="password" required class="input input-bordered w-full">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
