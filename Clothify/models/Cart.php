<?php
class Cart {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Add product to cart
    public function addToCart($user_id, $product_id, $quantity){
        // Check if product already exists in cart
        $stmt = $this->conn->prepare("SELECT quantity FROM cart WHERE user_id=? AND product_id=?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            // Product exists → update quantity
            $row = $result->fetch_assoc();
            $newQty = $row['quantity'] + $quantity;
            $update = $this->conn->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?");
            $update->bind_param("iii", $newQty, $user_id, $product_id);
            $update->execute();
            $update->close();
        } else {
            // Product not in cart → insert new
            $insert = $this->conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $insert->bind_param("iii", $user_id, $product_id, $quantity);
            $insert->execute();
            $insert->close();
        }

        $stmt->close();
        return true;
    }

    // Get all cart items for a user
    public function getCartItems($user_id){
        $stmt = $this->conn->prepare("
            SELECT c.product_id, c.quantity, p.name, p.price, p.image_path
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $items;
    }

    // Remove a product from cart
    public function removeItem($user_id, $product_id){
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    // Clear entire cart
    public function clearCart($user_id){
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
}
?>
