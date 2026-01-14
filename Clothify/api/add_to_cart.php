<?php
session_start();
include __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>false, 'message'=>'Please login']);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 1;

if(!$product_id){
    echo json_encode(['status'=>false, 'message'=>'No product specified']);
    exit;
}

// Check if product already in cart
$check = $conn->prepare("SELECT id, quantity FROM carts WHERE user_id=? AND product_id=?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$res = $check->get_result();

if($res->num_rows > 0){
    // Update quantity
    $row = $res->fetch_assoc();
    $newQty = $row['quantity'] + $quantity;

    $update = $conn->prepare("UPDATE carts SET quantity=?, updated_at=NOW() WHERE id=?");
    $update->bind_param("ii", $newQty, $row['id']);
    $update->execute();
}else{
    // Insert new
    $insert = $conn->prepare("INSERT INTO carts (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, NOW())");
    $insert->bind_param("iii", $user_id, $product_id, $quantity);
    $insert->execute();
}

echo json_encode(['status'=>true, 'message'=>'Product added to cart']);
?>
