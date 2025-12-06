<?php
include __DIR__ . '/../config/db.php';

class Product {
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    // Get all products
    public function getAllProducts(){
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $products = [];
        while($row = $result->fetch_assoc()){
            $products[] = $row;
        }
        return $products;
    }

    // Get products by category
    public function getProductsByCategory($category_id){
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE category_id=?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while($row = $result->fetch_assoc()){
            $products[] = $row;
        }
        return $products;
    }

    // Get single product
    public function getProductById($id){
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
