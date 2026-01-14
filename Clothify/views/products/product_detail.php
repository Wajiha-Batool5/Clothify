<?php
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/ProductController.php';

session_start();

$productController = new ProductController($conn);
$product_id = $_GET['id'] ?? null;

if (!$product_id) die("Product not specified.");

$product = $productController->getProductById($product_id);

if (!$product) die("Product not found.");

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // assuming you store logged in user ID in session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']); ?> - Clothify</title>
    <link rel="stylesheet" href="/project/Clothify/assets/css/product_detail.css">
</head>
<body>

<div class="product-detail-container">

    <!-- LEFT SIDE : PRODUCT IMAGE -->
    <div class="product-image">
        <?php
        $imagePath = '/project/Clothify/assets/images/products/' . $product['image_path'];
        if (file_exists(__DIR__ . '/../../assets/images/products/' . $product['image_path'])): ?>
            <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <?php else: ?>
            <img src="/project/Clothify/assets/images/products/default.png" alt="No image available">
        <?php endif; ?>
    </div>

    <!-- RIGHT SIDE : PRODUCT INFO -->
    <div class="product-info">
        <h1><?= htmlspecialchars($product['name']); ?></h1>

        <p class="price">Rs. <?= htmlspecialchars($product['price']); ?></p>

        <p class="description">
            <?= nl2br(htmlspecialchars($product['description'])); ?>
        </p>

        <!-- PURCHASE AREA -->
        <div class="purchase-box">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" value="1" min="1">

            <?php if($isLoggedIn): ?>
                <button id="addToCartBtn">Add to Cart</button>
                <p id="statusMsg"></p>
            <?php else: ?>
                <p class="login-warning">
                    Please <a href="/project/Clothify/views/auth/login.php">login</a> to add this product to your cart.
                </p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php if($isLoggedIn): ?>
<script>
document.getElementById('addToCartBtn').addEventListener('click', function() {
    const qty = parseInt(document.getElementById('quantity').value);
    const formData = new FormData();
    formData.append('product_id', <?= $product_id ?>);
    formData.append('quantity', qty);

    fetch('/project/Clothify/api/add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status){
            window.location.href = "/project/Clothify/views/cart/view_cart.php";
        } else {
            document.getElementById('statusMsg').innerText = data.message;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error adding to cart');
    });
});
</script>
<?php endif; ?>

<a href="/project/Clothify/index.php">Back to Shop</a>
</body>
</html>
