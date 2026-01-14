<?php
session_start();
include __DIR__ . '/../../config/db.php';

if(!isset($_SESSION['user_id'])){
    die("Please login first. <a href='../auth/login.php'>Login</a>");
}

$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment'] ?? 'card';
$fullname = $_POST['fullname'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';

// Fetch cart items
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

// If cart empty, redirect back
if(count($cart_items) == 0){
    die("Your cart is empty. <a href='../../index.php'>Go shopping</a>");
}

// Calculate total
$total = 0;
foreach($cart_items as $item){
    $total += $item['price'] * $item['quantity'];
}

// Save order to DB (for both COD and Card)
$orderStmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status, created_at) VALUES (?, ?, ?, NOW())");
$status = 'pending';
$orderStmt->bind_param("ids", $user_id, $total, $status);
$orderStmt->execute();
$order_id = $orderStmt->insert_id;

// Insert each item into order_items table
$itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");
foreach($cart_items as $item){
    $itemStmt->bind_param("iidi", $order_id, $item['product_id'], $item['price'], $item['quantity']);
    $itemStmt->execute();
}

// Clear user's cart
$clearCart = $conn->prepare("DELETE FROM carts WHERE user_id = ?");
$clearCart->bind_param("i", $user_id);
$clearCart->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $payment_method === 'cod' ? 'COD Confirmation' : 'Pay Now' ?> - Clothify</title>
    <link rel="stylesheet" href="../../assets/css/paynow.css">
</head>
<body>
<div class="paynow-wrapper">
    <div class="paynow-card">
        <h2><?= $payment_method === 'cod' ? 'Confirm Order - COD' : 'Pay Now' ?></h2>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <?php foreach($cart_items as $item): ?>
                <div class="order-item">
                    <img src="/project/Clothify/assets/images/products/<?= htmlspecialchars($item['image_path']) ?>" width="60" alt="<?= htmlspecialchars($item['name']) ?>">
                    <span><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></span>
                    <span>Rs. <?= $item['price'] * $item['quantity'] ?></span>
                </div>
            <?php endforeach; ?>
            <div class="order-total">
                Total: Rs. <span id="total-amount"><?= $total ?></span>
            </div>
        </div>

        <?php if($payment_method === 'card'): ?>
        <!-- Card Payment Form -->
        <div class="card-details">
            <h3>Card Information</h3>
            <div class="form-group">
                <label>Cardholder Name</label>
                <input type="text" id="card-name" required>
            </div>
            <div class="form-group">
                <label>Card Number</label>
                <input type="text" id="card-number" required>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label>Expiry</label>
                    <input type="text" id="expiry" required>
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="text" id="cvv" required>
                </div>
            </div>
        </div>
        <form method="POST" action="../confirmation/confirmation.php">
            <input type="hidden" name="total" value="<?= $total ?>">
            <input type="hidden" name="order_id" value="<?= $order_id ?>">
            <button type="submit" class="pay-btn">Pay Now</button>
        </form>

        <?php else: ?>
        <!-- COD Confirmation -->
        <div class="cod-confirmation">
            <p>Your order will be delivered to your address. Please keep Rs. <?= $total ?> ready for Cash on Delivery.</p>
            <form method="POST" action="../confirmation/confirmation.php">
                <input type="hidden" name="total" value="<?= $total ?>">
                <input type="hidden" name="order_id" value="<?= $order_id ?>">
                <button type="submit" class="pay-btn">Confirm Order</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
