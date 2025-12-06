<?php
session_start();
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../controllers/CartController.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>false]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);

$cartController = new CartController($conn);
$cartController->updateQuantity($user_id, $product_id, $quantity);

echo json_encode(['status'=>true]);
