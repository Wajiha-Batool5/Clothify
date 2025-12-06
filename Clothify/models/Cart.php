<?php
include __DIR__ . '/../config/db.php';

class Cart {
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function addToCart($user_id, $product_id, $quantity){
        // Check if product already in cart
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id=? AND product_id=?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            // Update quantity
            $stmt = $this->conn->prepare("UPDATE cart SET quantity=quantity+? WHERE user_id=? AND product_id=?");
            $stmt->bind_param("iii", $quantity, $user_id, $product_id);
            return $stmt->execute();
        } else {
            // Insert new item
            $stmt = $this->conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,?)");
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
            return $stmt->execute();
        }
    }

    public function getCartItems($user_id){
        $stmt = $this->conn->prepare("SELECT cart.*, products.name, products.price, products.image 
                                      FROM cart 
                                      JOIN products ON cart.product_id = products.id 
                                      WHERE cart.user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while($row = $result->fetch_assoc()){
            $items[] = $row;
        }
        return $items;
    }

    public function removeItem($user_id, $product_id){
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
        $stmt->bind_param("ii", $user_id, $product_id);
        return $stmt->execute();
    }

    public function clearCart($user_id){
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}
?>
