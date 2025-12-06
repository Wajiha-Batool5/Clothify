<?php
include __DIR__ . '/../config/db.php';

class Order {
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    // Place order
    public function placeOrder($user_id, $total_amount, $cart_items){
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $total_amount);
        if($stmt->execute()){
            $order_id = $stmt->insert_id;

            // Insert order items
            $stmt_item = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?,?,?,?)");
            foreach($cart_items as $item){
                $stmt_item->bind_param("iiid", $order_id, $item['product_id'], $item['price'], $item['quantity']);
                $stmt_item->execute();
            }

            return $order_id;
        }
        return false;
    }

    // Get orders by user
    public function getOrdersByUser($user_id){
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get order items
    public function getOrderItems($order_id){
        $stmt = $this->conn->prepare("SELECT order_items.*, products.name, products.image 
                                      FROM order_items 
                                      JOIN products ON order_items.product_id=products.id 
                                      WHERE order_items.order_id=?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
