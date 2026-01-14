<?php
session_start();
include __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>false, 'message'=>'Please login']);
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_id = $_POST['cart_id'] ?? null;

if(!$cart_id){
    echo json_encode(['status'=>false, 'message'=>'Invalid cart item']);
    exit;
}

// Delete item
$delete = $conn->prepare("DELETE FROM carts WHERE id=? AND user_id=?");
$delete->bind_param("ii", $cart_id, $user_id);
$delete->execute();

echo json_encode(['status'=>true, 'message'=>'Item removed']);
?>
