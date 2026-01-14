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
$change = $_POST['change'] ?? null;

if(!$cart_id || !$change){
    echo json_encode(['status'=>false, 'message'=>'Invalid data']);
    exit;
}

// Get current quantity
$query = $conn->prepare("SELECT quantity FROM carts WHERE id=? AND user_id=?");
$query->bind_param("ii", $cart_id, $user_id);
$query->execute();
$result = $query->get_result();

if($result->num_rows === 0){
    echo json_encode(['status'=>false, 'message'=>'Cart item not found']);
    exit;
}

$row = $result->fetch_assoc();
$newQty = $row['quantity'] + $change;
if($newQty < 1) $newQty = 1;

// Update quantity
$update = $conn->prepare("UPDATE carts SET quantity=?, updated_at=NOW() WHERE id=? AND user_id=?");
$update->bind_param("iii", $newQty, $cart_id, $user_id);
$update->execute();

echo json_encode(['status'=>true, 'newQty'=>$newQty]);
?>
