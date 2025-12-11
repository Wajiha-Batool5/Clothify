<?php
session_start();
if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>false,'message'=>'Not logged in']);
    exit;
}

include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/CartController.php';

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;

if(!$product_id || !$quantity){
    echo json_encode(['status'=>false,'message'=>'Invalid data']);
    exit;
}

$cartController = new CartController($conn);
$updated = $cartController->updateCartItem($user_id, $product_id, $quantity);

if($updated){
    echo json_encode(['status'=>true]);
}else{
    echo json_encode(['status'=>false,'message'=>'Failed to update cart']);
}
?>

