<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../db.php';
include 'navbar.php';

$message = '';

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = intval($_GET['id']);

// Retrieve product details
$stmt = $pdo->prepare("SELECT * FROM food_items WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $price = floatval($_POST['price']);
    $description = htmlspecialchars(trim($_POST['description']));
    
    $filename = $product['image']; // Default to existing image
    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../assets/uploads/';
        $newFilename = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $newFilename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Delete the old image file if it exists
            $oldImage = $upload_dir . $product['image'];
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            $filename = $newFilename;
        } else {
            $message = "Failed to upload new image.";
        }
    }
    
    // Update product details in the database
    $stmt = $pdo->prepare("UPDATE food_items SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
    if ($stmt->execute([$name, $price, $description, $filename, $product_id])) {
        $message = "Product updated successfully!";
        // Reload the updated product data
        $stmt = $pdo->prepare("SELECT * FROM food_items WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
    } else {
        $message = "Failed to update product.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container mx-auto py-4">
    <h1 class="text-3xl font-bold mb-4">Edit Product</h1>
    <?php if ($message): ?>
      <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="label">Product Name</label>
            <input type="text" name="name" required class="input input-bordered w-full" value="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div>
            <label class="label">Price</label>
            <input type="number" step="0.01" name="price" required class="input input-bordered w-full" value="<?php echo htmlspecialchars($product['price']); ?>">
        </div>
        <div>
            <label class="label">Description</label>
            <textarea name="description" required class="textarea textarea-bordered w-full"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div>
            <label class="label">Current Image</label><br>
            <?php if ($product['image']): ?>
                <img src="../assets/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 150px;">
            <?php endif; ?>
        </div>
        <div>
            <label class="label">Change Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
    <div class="mt-4">
        <a href="products.php" class="btn btn-secondary">Back to Products</a>
    </div>
</div>
</body>
</html>
