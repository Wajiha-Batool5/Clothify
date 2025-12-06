<?php
include __DIR__ . '/../models/Order.php';

class OrderController {
    private $orderModel;
    public function __construct($conn){
        $this->orderModel = new Order($conn);
    }

    public function placeOrder($user_id, $total_amount, $cart_items){
        return $this->orderModel->placeOrder($user_id, $total_amount, $cart_items);
    }

    public function getOrdersByUser($user_id){
        return $this->orderModel->getOrdersByUser($user_id);
    }

    public function getOrderItems($order_id){
        return $this->orderModel->getOrderItems($order_id);
    }
}
?>
