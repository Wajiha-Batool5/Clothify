<?php
class ProductController {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Get a single product by ID
    public function getProductById($id){
        $stmt = $this->conn->prepare("SELECT id, name, category_id, price, description, image, image_path 
                                      FROM products 
                                      WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        return $product;
    }

    // Get all products
    public function getAllProducts(){
        $query = "SELECT id, name, category_id, price, description, image, image_path 
                  FROM products ORDER BY id DESC";

        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get products by category
    public function getProductsByCategory($category_id){
        $stmt = $this->conn->prepare("SELECT id, name, price, description, image, image_path 
                                      FROM products 
                                      WHERE category_id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }
}
