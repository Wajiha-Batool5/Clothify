<?php
include __DIR__ . '/../models/Cart.php';

class CartController {
    private $cartModel;
    public function __construct($conn){
        $this->cartModel = new Cart($conn);
    }

    public function addToCart($user_id, $product_id, $quantity){
        return $this->cartModel->addToCart($user_id, $product_id, $quantity);
    }

    public function getCartItems($user_id){
        return $this->cartModel->getCartItems($user_id);
    }

    public function removeItem($user_id, $product_id){
        return $this->cartModel->removeItem($user_id, $product_id);
    }

    public function clearCart($user_id){
        return $this->cartModel->clearCart($user_id);
    }
}
?>
