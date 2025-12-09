<?php include "../config/db.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
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
        <header>Manage Users</header>

        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>
            <?php
            $users = $conn->query("SELECT * FROM users");
            while($u = $users->fetch_assoc()) {
                echo "<tr>
                        <td>{$u['id']}</td>
                        <td>{$u['username']}</td>
                        <td>{$u['email']}</td>
                        <td>{$u['role']}</td>
                        <td>{$u['created_at']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
