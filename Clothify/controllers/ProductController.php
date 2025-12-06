<?php
include __DIR__ . '/../models/Product.php';

class ProductController {
    private $productModel;
    public function __construct($conn){
        $this->productModel = new Product($conn);
    }

    public function getAllProducts(){
        return $this->productModel->getAllProducts();
    }

    public function getProductsByCategory($category_id){
        return $this->productModel->getProductsByCategory($category_id);
    }

    public function getProductById($id){
        return $this->productModel->getProductById($id);
    }
}
?>
