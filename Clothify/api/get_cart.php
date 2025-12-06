<?php
session_start();
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../controllers/CartController.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];
$cartController = new CartController($conn);
$cart_items = $cartController->getCartItems($user_id);

// Return JSON
echo json_encode($cart_items);
