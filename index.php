<?php
session_start();

require 'db.php'; 

// Fetch all food items from the database
$stmt = $pdo->query("SELECT * FROM food_items");
$foods = $stmt->fetchAll();
include 'navbar.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Restaurant Home</title>
    <!-- DaisyUI CDN (includes Tailwind CSS) -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto py-4">
    <div
  class="hero min-h-screen"
  style="background-image: url(assets/uploads/05.png);">
  <div class="hero-overlay"></div>
  <div class="hero-content text-neutral-content text-center">
    <div class="max-w-md">
      <h1 class="mb-5 text-5xl font-bold">Hello there</h1>
      <p class="mb-5">
        Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
        quasi. In deleniti eaque aut repudiandae et a id nisi.
      </p>
    <a href="products.php">  <button class="btn btn-primary">Get Started</button></a>
    </div>
  </div>
</div>

        <h1 class="text-4xl font-bold mb-4">Our Menu</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php foreach ($foods as $food): ?>
            <div class="card bg-base-100 shadow-xl">
                <figure>
                    <img src="assets/uploads/<?php echo htmlspecialchars($food['image']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>">
                </figure>
                <div class="card-body">
                    <h2 class="card-title"><?php echo htmlspecialchars($food['name']); ?></h2>
                    <p>$<?php echo htmlspecialchars($food['price']); ?></p>
                    <div class="card-actions justify-end">
                        <a href="product.php?id=<?php echo $food['id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>