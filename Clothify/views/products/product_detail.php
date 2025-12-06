<?php
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/ProductController.php';
session_start();

$productController = new ProductController($conn);

// Get product ID
$product_id = $_GET['id'] ?? null;
if(!$product_id) die("Product not specified.");

$product = $productController->getProductById($product_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?> - Clothify</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<h1><?php echo htmlspecialchars($product['name']); ?></h1>
<img src="../../assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
<p>Price: Rs. <?php echo $product['price']; ?></p>
<p><?php echo $product['description']; ?></p>

<label>Quantity:</label>
<input type="number" id="quantity" value="1" min="1">

<button id="addToCartBtn">Add to Cart</button>
<p id="statusMsg" style="color:green;"></p>

<script>
document.getElementById('addToCartBtn').addEventListener('click', function() {
    const qty = parseInt(document.getElementById('quantity').value);
    const formData = new FormData();
    formData.append('product_id', <?php echo $product_id; ?>);
    formData.append('quantity', qty);

    fetch('../../api/add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const statusMsg = document.getElementById('statusMsg');
        if(data.status){
            statusMsg.innerText = "Added to cart successfully!";
            // Optional: update cart dynamically if view_cart.php is open in iframe or separate section
        } else {
            statusMsg.innerText = data.message;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error adding to cart');
    });
});
</script>

<a href="shop.php">Back to Shop</a>
</body>
</html>
