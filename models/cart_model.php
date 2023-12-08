<?php

class CartModel {

    public function addToCart($user_id, $product_id, $quantity) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO `cart` (`user_id`, `product_id`, `quantity`) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function removeFromCart($cart_id) {
      global $conn;
      $stmt = $conn->prepare("DELETE FROM `cart` WHERE `id` = :cart_id");
      $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->rowCount() > 0;
  }
  

  public function getCartItems($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $cartItems;
}

    // Add other methods related to cart here...

}

?>
