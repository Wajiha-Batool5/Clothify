<?php
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/ProductController.php';

// Instantiate ProductController
$productController = new ProductController($conn);

// Fetch all products
$products = $productController->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothify - Shop</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<h1>Shop All Products</h1>
<div class="products-container">
    <?php foreach($products as $product): ?>
        <div class="product-card">
            <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                <img src="../../assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p>Price: $<?php echo $product['price']; ?></p>
            </a>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
