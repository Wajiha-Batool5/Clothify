<?php
include __DIR__ . '/../config/db.php';

class Category {
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getAllCategories(){
        $sql = "SELECT * FROM categories";
        $result = $this->conn->query($sql);
        $categories = [];
        while($row = $result->fetch_assoc()){
            $categories[] = $row;
        }
        return $categories;
    }

    public function getCategoryById($id){
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
