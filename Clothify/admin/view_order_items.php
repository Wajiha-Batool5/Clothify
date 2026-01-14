<?php
include __DIR__ . '/../config/db.php';

$order_id = $_GET['order_id'] ?? 0;

$stmt = $conn->prepare("
    SELECT oi.*, p.name AS product_name, p.image_path 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate grand total
$grand_total = 0;
foreach($order_items as $item){
    $grand_total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order #<?= $order_id ?> Items - Clothify Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Clothify Admin</h2>
        <a href="index.php">Dashboard</a>
        <a href="add_product.php">Add Product</a>
        <a href="edit_product.php">Edit Products</a>
        <a href="view_orders.php">Orders</a>
        <a href="manage_users.php">Users</a>
    </div>

    <div class="container">
        <div class="order-container">
            <header>Order #<?= $order_id ?> Items</header>

            <table class="order-table">
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php foreach($order_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>
                        <img src="/project/Clothify/assets/images/products/<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                    </td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rs. <?= number_format($item['price'], 2) ?></td>
                    <td>Rs. <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <p class="order-total">Grand Total: Rs. <?= number_format($grand_total, 2) ?></p>
<br>
            <a href="view_orders.php" class="back-btn">Back to Orders</a>
        </div>
    </div>
</body>
</html>
