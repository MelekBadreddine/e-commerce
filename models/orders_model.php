<?php

class OrdersModel {

  public function placeOrder($user_id, $cartItems, $conn) {
      $conn->beginTransaction(); // Begin a transaction
      $success = true;

      // Insert order details
      $stmt = $conn->prepare("INSERT INTO `orders` (`user_id`) VALUES (:user_id)");
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $order_id = $conn->lastInsertId();

      if ($order_id) {
          // Insert order items
          foreach ($cartItems as $cartItem) {
              $product_id = $cartItem['product_id'];
              $quantity = $cartItem['quantity'];

              $stmt = $conn->prepare("INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`) VALUES (:order_id, :product_id, :quantity)");
              $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
              $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
              $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
              $stmt->execute();

              if ($stmt->rowCount() <= 0) {
                  $success = false;
                  break;
              }
          }

          // Clear the cart
          if ($success) {
              $stmt = $conn->prepare("DELETE FROM `cart` WHERE `user_id` = :user_id");
              $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
              $stmt->execute();
              if ($stmt->rowCount() <= 0) {
                  $success = false;
              }
          }
      } else {
          $success = false;
      }

      if ($success) {
          $conn->commit(); // Commit the transaction if successful
      } else {
          $conn->rollBack(); // Rollback if any failure occurs
      }

      return $success;
  }

  public function getOrderHistory($user_id, $conn) {
      $stmt = $conn->prepare("SELECT * FROM `orders` WHERE `user_id` = :user_id");
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $orders;
  }

  // Add other methods related to orders here...

}



?>