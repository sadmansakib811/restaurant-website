<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../db.php';
include 'navbar.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $price = floatval($_POST['price']);
    $description = htmlspecialchars(trim($_POST['description']));
    
    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../assets/uploads/';
        $filename = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO food_items (name, price, description, image) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $price, $description, $filename])) {
                $message = "Product added successfully!";
            } else {
                $message = "Database error, please try again.";
            }
        } else {
            $message = "Failed to upload image.";
        }
    } else {
        $message = "Please select an image.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="container mx-auto py-4">
    <h1 class="text-3xl font-bold mb-4">Add New Product</h1>
    <?php if ($message): ?>
      <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="label">Product Name</label>
            <input type="text" name="name" required class="input input-bordered w-full">
        </div>
        <div>
            <label class="label">Price</label>
            <input type="number" step="0.01" name="price" required class="input input-bordered w-full">
        </div>
        <div>
            <label class="label">Description</label>
            <textarea name="description" required class="textarea textarea-bordered w-full"></textarea>
        </div>
        <div>
            <label class="label">Image</label>
            <input type="file" name="image" accept="image/*" required class="file-input file-input-bordered w-full">
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
    <div class="mt-4">
        <a href="products.php" class="btn btn-secondary">Back to Products</a>
    </div>
</div>
</body>
</html>
