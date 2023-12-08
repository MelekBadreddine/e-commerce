<?php

include '../models/cart_model.php';

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    public function addToCart($user_id, $product_id, $quantity) {
        return $this->cartModel->addToCart($user_id, $product_id, $quantity);
    }

    public function removeFromCart($cart_id) {
        return $this->cartModel->removeFromCart($cart_id);
    }

    public function getCartItems($user_id) {
        return $this->cartModel->getCartItems($user_id);
    }

    public function clearCart($user_id) {
      global $conn;
      $stmt = $conn->prepare("DELETE FROM `cart` WHERE `user_id` = :user_id");
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->rowCount() > 0;
  }

    // Other cart-related methods...

}

?>