<?php
include __DIR__ . '/../config/db.php';

// Fetch all orders with user info
$orders = $conn->query("
    SELECT o.*, u.username 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
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
        <header>Orders</header>

        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Items</th>
            </tr>
        <?php while($row = $orders->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td>Rs. <?= $row['total_amount'] ?></td>
        <td><?= ucfirst($row['status']) ?></td>
        <td><?= $row['created_at'] ?></td>
        <td><a href="view_order_items.php?order_id=<?= $row['id'] ?>">View Items</a></td>
    </tr>
    <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
