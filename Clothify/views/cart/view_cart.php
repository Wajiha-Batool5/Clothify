<?php
session_start();
include __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['user_id'])){
    die("Please login to view your cart. <a href='../auth/login.php'>Login</a>");
}

$user_id = $_SESSION['user_id'];

// Get cart items
$query = $conn->prepare("
    SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.image_path, c.quantity
    FROM carts c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../../assets/css/addtocart.css">
</head>
<body>
<div class="cart-container">
    <h2>Your Cart</h2>

    <?php if($result->num_rows > 0): ?>
        <div id="cartItems">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="cart-item" data-cart-id="<?= $row['cart_id'] ?>">
                <img src="/project/Clothify/assets/images/products/<?= htmlspecialchars($row['image_path']) ?>" 
                     alt="<?= htmlspecialchars($row['name']) ?>">

                <div class="item-details">
                    <h4><?= htmlspecialchars($row['name']) ?></h4>
                    <p>Price: Rs. <span class="price"><?= $row['price'] ?></span></p>

                    <div class="qty-box">
                        <button class="qty-btn" onclick="updateQty(<?= $row['cart_id'] ?>, -1)">-</button>
                        <span class="quantity"><?= $row['quantity'] ?></span>
                        <button class="qty-btn" onclick="updateQty(<?= $row['cart_id'] ?>, 1)">+</button>
                    </div>

                    <p>Total: Rs. <span class="total"><?= $row['price'] * $row['quantity'] ?></span></p>

                    <button class="remove-btn" onclick="removeItem(<?= $row['cart_id'] ?>)">Remove</button>
                </div>
            </div>
        <?php endwhile; ?>
        </div>

        <div class="cart-summary">
            Subtotal: Rs. <span id="subtotal">0</span>
        </div>

        <a href="../checkout/checkout.php">
            <button class="checkout-btn">Checkout</button>
        </a>
    <?php else: ?>
        <p style="text-align:center; font-size:18px;">Your cart is empty.</p>
    <?php endif; ?>
</div>

<script>
// Update subtotal
function updateSubtotal() {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        total += parseInt(item.querySelector('.total').innerText);
    });
    document.getElementById('subtotal').innerText = total;
}
updateSubtotal();

// Update quantity via AJAX
function updateQty(cartId, change) {
    const cartItem = document.querySelector(`[data-cart-id='${cartId}']`);
    const qtySpan = cartItem.querySelector('.quantity');
    const price = parseInt(cartItem.querySelector('.price').innerText);

    fetch('/project/Clothify/api/update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `cart_id=${cartId}&change=${change}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            qtySpan.innerText = data.newQty;
            cartItem.querySelector('.total').innerText = data.newQty * price;
            updateSubtotal();
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}

// Remove item via AJAX
function removeItem(cartId) {
    fetch('/project/Clothify/api/remove_cart_item.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `cart_id=${cartId}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            document.querySelector(`[data-cart-id='${cartId}']`).remove();
            updateSubtotal();
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}
</script>
</body>
</html>
