<?php
session_start();

// Read total
$total = $_POST['total'] ?? 0;

// Generate random order number
$orderNumber = "ORD-" . rand(100000, 999999);

// Clear user's cart after order
include __DIR__ . '/../../config/db.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("DELETE FROM carts WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - Clothify</title>
    <!-- Absolute path ensures CSS always loads -->
    <link rel="stylesheet" href="/project/Clothify/assets/css/confirmation.css">
</head>
<body>
<div class="confirm-wrapper">
    <div class="confirm-card">
        <h2>Order Confirmed!</h2>
        <p class="thank-you">Thank you for shopping with Clothify!</p>

        <p><strong>Order Number:</strong> <?= $orderNumber ?></p>
        <p><strong>Total:</strong> Rs. <?= $total ?></p>
        <p><strong>Delivery:</strong> 3-5 business days</p>

        <a href="/project/Clothify/index.php" class="back-home">Return to Home</a>
    </div>
</div>
</body>
</html>
