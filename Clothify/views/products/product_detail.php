<?php
// Include header (path relative to this file: views/products)
include __DIR__ . "/../include/header.php";

// Get product id from query string
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 1;


$product = null;

// Try DB first (if configured). This allows using MySQL data instead of the hardcoded array.
$dbFile = __DIR__ . '/../../config/db.php';
$modelFile = __DIR__ . '/../../models/Product.php';
if (file_exists($dbFile) && file_exists($modelFile)) {
    require_once $dbFile;
    require_once $modelFile;
    $product = Product::find($product_id);
}

// Fallback to hardcoded products array
if (!$product) {
    $product = isset($products[$product_id]) ? $products[$product_id] : null;
}

if (!$product) {
    echo '<div class="product-detail"><p>Product not found.</p></div>';
    include __DIR__ . "/../include/footer.php";
    exit;
}
?>

<?php
// Build URL-safe image path: keep directories, urlencode only the filename
$rawImage = isset($product['image']) ? str_replace('\\', '/', $product['image']) : '';
$imageUrl = '';
if ($rawImage !== '') {
    $parts = explode('/', $rawImage);
    $filename = array_pop($parts);
    $dir = implode('/', $parts);
    $imageUrl = '../../assets/images/products/' . ($dir ? $dir . '/' : '') . rawurlencode($filename);
}
?>
<div class="product-detail">
    <img src="<?= $imageUrl ?: '../../assets/images/products/placeholder.jpg' ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="detail-img">


    <div class="detail-info">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p class="price"><?= htmlspecialchars($product['price']) ?></p>
        <?php if (!empty($product['category'])): ?>
            <p class="category">Category: <?= htmlspecialchars(ucwords(str_replace(['-','_'], ' ', $product['category']))) ?></p>
        <?php endif; ?>
        <p class="description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        
        <label>Size:</label>
        <select>
            <option>Small</option>
            <option>Medium</option>
            <option>Large</option>
        </select>

        <a href="../../cart.php" class="btn">Add to Cart</a>
    </div>
</div>

<?php include __DIR__ . "/../include/footer.php"; ?>
