<?php
// signup.php - User registration form

require 'db.php';
include 'navbar.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email    = htmlspecialchars(trim($_POST['email']));
    // Hash the password before storing it
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Insert the user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $password])) {
        $message = "Signup successful! You can now log in.";
    } else {
        $message = "Signup failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Sign Up</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-4">
            <div>
                <label class="label">Username</label>
                <input type="text" name="username" required class="input input-bordered w-full">
            </div>
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" required class="input input-bordered w-full">
            </div>
            <div>
                <label class="label">Password</label>
                <input type="password" name="password" required class="input input-bordered w-full">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
</body>
</html>
