<?php
include __DIR__ . '/../models/Cart.php';

class CartController {
    private $cartModel;

    public function __construct($conn){
        $this->cartModel = new Cart($conn);
    }

    // Add product to cart (or increase quantity if already exists)
    public function addToCart($user_id, $product_id, $quantity){
        return $this->cartModel->addToCart($user_id, $product_id, $quantity);
    }

    // Get all items in user's cart
    public function getCartItems($user_id){
        return $this->cartModel->getCartItems($user_id);
    }

    // Remove an item from the cart
    public function removeItem($user_id, $product_id){
        return $this->cartModel->removeItem($user_id, $product_id);
    }

    // Clear entire cart (after checkout)
    public function clearCart($user_id){
        return $this->cartModel->clearCart($user_id);
    }
}
?>
