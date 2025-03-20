<?php
// login.php - User login form

require 'db.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    // Retrieve user record by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify the password using password_verify()
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Login</h1>
        <?php if ($message): ?>
            <div class="alert alert-error"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-4">
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" required class="input input-bordered w-full">
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
