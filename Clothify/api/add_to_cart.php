<?php
session_start();

// Make sure the product data is sent via POST
if(isset($_POST['product_id'], $_POST['name'], $_POST['price'], $_POST['image'], $_POST['qty'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $qty = $_POST['qty'];

    // Initialize cart if not already
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product already in cart
    $found = false;
    foreach($_SESSION['cart'] as &$item) {
        if($item['product_id'] == $product_id) {
            $item['qty'] += $qty; // Increase quantity
            $found = true;
            break;
        }
    }

    if(!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'qty' => $qty
        ];
    }

    echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product data']);
}
