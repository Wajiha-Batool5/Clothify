<?php
include __DIR__ . '/../include/header.php';
include __DIR__ . '/../include/navbar.php';
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/ProductController.php';

session_start();

// Create controller instance
$productController = new ProductController($conn);

// Get products in Wedding Wear category (category_id = 3)
$categoryId = 3;
$products = $productController->getProductsByCategory($categoryId);
?>

<link rel="stylesheet" href="/project/Clothify/assets/css/products.css">

<div class="product-container">
    <h2>Wedding Wear</h2>

    <div class="product-grid">
        <?php foreach ($products as $p): ?>
    <div class="product-card">
        
        <img src="/project/Clothify/assets/images/products/<?= $p['image_path'] ?>" 
             alt="<?= htmlspecialchars($p['name']) ?>">

        <h3><?= htmlspecialchars($p['name']) ?></h3>

        <p class="price">Rs. <?= $p['price'] ?></p>

        <a href="/project/Clothify/views/products/product_detail.php?id=<?= $p['id'] ?>" 
           class="view-btn">View Details</a>
    </div>
<?php endforeach; ?>

    </div>
</div>

<?php include __DIR__ . '/../include/footer.php'; ?>
