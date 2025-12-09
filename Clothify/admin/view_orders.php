<?php include "../config/db.php"; ?>

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
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        <?php
        $orders = $conn->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id=u.id");
        while($o = $orders->fetch_assoc()) {
            $statusClass = "status-{$o['status']}";
            echo "<tr>
                    <td>{$o['id']}</td>
                    <td>{$o['username']}</td>
                    <td>{$o['total_amount']}</td>
                    <td><span class='badge {$statusClass}'>" . ucfirst($o['status']) . "</span></td>
                    <td>{$o['created_at']}</td>
                  </tr>";
        }
        ?>
        </table>
    </div>
</body>
</html>
