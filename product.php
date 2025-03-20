<?php
// product.php - Display details of a single food item

require 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM food_items WHERE id = ?");
$stmt->execute([$id]);
$food = $stmt->fetch();

if (!$food) {
    die("Food item not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($food['name']); ?> - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mx-auto py-4">
        <a href="index.php" class="btn btn-secondary mb-4">Back to Menu</a>
        <div class="card bg-base-100 shadow-xl">
            <figure>
                <img src="assets/uploads/<?php echo htmlspecialchars($food['image']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>">
            </figure>
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($food['name']); ?></h2>
                <p><?php echo htmlspecialchars($food['description']); ?></p>
                <p class="text-xl font-bold">$<?php echo htmlspecialchars($food['price']); ?></p>
                <div class="card-actions justify-end">
                    <form method="post" action="cart.php">
                        <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>