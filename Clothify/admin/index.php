<?php
include "../config/db.php";

// Count products
$p = $conn->query("SELECT COUNT(*) AS total FROM products");
$totalProducts = $p->fetch_assoc()['total'];

// Count users
$u = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $u->fetch_assoc()['total'];

// Count orders
$o = $conn->query("SELECT COUNT(*) AS total FROM orders");
$totalOrders = $o->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
        <header>Dashboard</header>

        <div class="dashboard-cards">
            <div class="card">
                <h2>Products</h2>
                <p><?= $totalProducts ?></p>
            </div>
            <div class="card">
                <h2>Users</h2>
                <p><?= $totalUsers ?></p>
            </div>
            <div class="card">
                <h2>Orders</h2>
                <p><?= $totalOrders ?></p>
            </div>
        </div>
    </div>
</body>
</html>
