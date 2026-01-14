<?php
session_start();
include __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['user_id'])){
    die("Please login to checkout. <a href='../auth/login.php'>Login</a>");
}

// Fetch cart items dynamically
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("
    SELECT p.id AS product_id, p.name, p.price, p.image_path, c.quantity
    FROM carts c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

if(count($cart_items) == 0){
    die("Your cart is empty. <a href='../../index.php'>Go shopping</a>");
}

// Calculate subtotal
$subtotal = 0;
foreach($cart_items as $item){
    $subtotal += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Clothify</title>
    <link rel="stylesheet" href="../../assets/css/checkout.css">
</head>
<body>
<div class="checkout-container">
    <h2>Checkout</h2>

    <form id="checkoutForm" method="POST" action="paynow.php">
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" id="phone" placeholder="+92 300 1234567" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="example@email.com" required>
        </div>

        <div class="form-group">
            <label for="address">Shipping Address</label>
            <textarea name="address" id="address" placeholder="Enter your address" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <div class="payment-methods">
                <label><input type="radio" name="payment" value="card" checked> Credit/Debit Card</label>
                <label><input type="radio" name="payment" value="cod"> Cash on Delivery</label>
            </div>
        </div>

        <input type="hidden" name="subtotal" value="<?= $subtotal ?>">

        <button type="submit" class="pay-btn">Proceed to Payment</button>
    </form>
</div>

</body>
</html>
