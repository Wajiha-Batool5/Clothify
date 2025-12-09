<?php
include __DIR__ . '/../include/header.php';
include __DIR__ . '/../include/navbar.php';
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/ProductController.php';

$categoryId = 2;   // party_wear category_id
$products = getProductsByCategory($conn, $categoryId);
?>

<link rel="stylesheet" href="/project/Clothify/assets/css/products.css">

<div class="product-container">
    <h2>Party Wear</h2>

    <div class="product-grid">
        <?php while ($p = $products->fetch_assoc()): ?>
            <div class="product-card">

                <img src="/project/Clothify/assets/images/products/party_wear/<?= $p['image'] ?>" 
                    alt="<?= htmlspecialchars($p['name']) ?>">

                <h3><?= htmlspecialchars($p['name']) ?></h3>

                <p class="price">$<?= $p['price'] ?></p>

                <a href="/project/Clothify/views/products/product_detail.php?id=<?= $p['id'] ?>" 
                   class="view-btn">View Details</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include __DIR__ . '/../include/footer.php'; ?>
