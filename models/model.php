<?php

include 'components/connect.php';

function getProductsByCategory($category_id) {
   global $conn;
   $stmt = $conn->prepare("SELECT * FROM `products` WHERE `category_id` = ?");
   $stmt->bind_param("i", $category_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $products = array();
   while ($row = $result->fetch_assoc()) {
      $products[] = $row;
   }
   return $products;
}

function getProductById($product_id) {
   global $conn;
   $stmt = $conn->prepare("SELECT * FROM `products` WHERE `id` = ?");
   $stmt->bind_param("i", $product_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $product = $result->fetch_assoc();
   return $product;
}

function addToCart($user_id, $product_id, $quantity) {
   global $conn;
   $stmt = $conn->prepare("INSERT INTO `cart` (`user_id`, `product_id`, `quantity`) VALUES (?, ?, ?)");
   $stmt->bind_param("iii", $user_id, $product_id, $quantity);
   $stmt->execute();
   return $stmt->affected_rows > 0;
}

function removeFromCart($cart_id) {
   global $conn;
   $stmt = $conn->prepare("DELETE FROM `cart` WHERE `id` = ?");
   $stmt->bind_param("i", $cart_id);
   $stmt->execute();
   return $stmt->affected_rows > 0;
}

function getCartItems($user_id) {
   global $conn;
   $stmt = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $cartItems = array();
   while ($row = $result->fetch_assoc()) {
      $cartItems[] = $row;
   }
   return $cartItems;
}

function placeOrder($user_id, $cartItems) {
   global $conn;
   $conn->autocommit(FALSE);
   $success = TRUE;

   // Insert order details
   $stmt = $conn->prepare("INSERT INTO `orders` (`user_id`) VALUES (?)");
   $stmt->bind_param("i", $user_id);
   $stmt->execute();
   $order_id = $stmt->insert_id;

   if ($order_id) {
      // Insert order items
      foreach ($cartItems as $cartItem) {
         $product_id = $cartItem['product_id'];
         $quantity = $cartItem['quantity'];

         $stmt = $conn->prepare("INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`) VALUES (?, ?, ?)");
         $stmt->bind_param("iii", $order_id, $product_id, $quantity);
         $stmt->execute();

         if ($stmt->affected_rows <= 0) {
            $success = FALSE;
            break;
         }
      }

      // Clear the cart
      if ($success) {
         $stmt = $conn->prepare("DELETE FROM `cart` WHERE `user_id` = ?");
         $stmt->bind_param("i", $user_id);
         $stmt->execute();
         if ($stmt->affected_rows <= 0) {
            $success = FALSE;
         }
      }
   } else {
      $success = FALSE;
   }

   if ($success) {
      $conn->commit();
   } else {
      $conn->rollback();
   }

   $conn->autocommit(TRUE);
   return $success;
}

function getUserById($user_id) {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM `users` WHERE `id` = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  return $user;
}

function registerUser($username, $password) {
  global $conn;
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $hashed_password);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function loginUser($username, $password) {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  
  if ($user && password_verify($password, $user['password'])) {
     return $user['id'];
  } else {
     return false;
  }
}

function createWishlist($user_id, $name) {
  global $conn;
  $stmt = $conn->prepare("INSERT INTO `wishlist` (`user_id`, `name`) VALUES (?, ?)");
  $stmt->bind_param("is", $user_id, $name);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function getWishlistByUser($user_id) {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM `wishlist` WHERE `user_id` = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $wishlist = array();
  while ($row = $result->fetch_assoc()) {
     $wishlist[] = $row;
  }
  return $wishlist;
}

function addToWishlist($wishlist_id, $product_id) {
  global $conn;
  $stmt = $conn->prepare("INSERT INTO `wishlist_items` (`wishlist_id`, `product_id`) VALUES (?, ?)");
  $stmt->bind_param("ii", $wishlist_id, $product_id);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function removeFromWishlist($wishlist_item_id) {
  global $conn;
  $stmt = $conn->prepare("DELETE FROM `wishlist_items` WHERE `id` = ?");
  $stmt->bind_param("i", $wishlist_item_id);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function getAllProducts() {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM `products`");
  $stmt->execute();
  $result = $stmt->get_result();
  $products = array();
  while ($row = $result->fetch_assoc()) {
     $products[] = $row;
  }
  return $products;
}

function createProduct($name, $price, $category_id) {
  global $conn;
  $stmt = $conn->prepare("INSERT INTO `products` (`name`, `price`, `category_id`) VALUES (?, ?, ?)");
  $stmt->bind_param("sdi", $name, $price, $category_id);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function updateProduct($product_id, $name, $price, $category_id) {
  global $conn;
  $stmt = $conn->prepare("UPDATE `products` SET `name` = ?, `price` = ?, `category_id` = ? WHERE `id` = ?");
  $stmt->bind_param("sdii", $name, $price, $category_id, $product_id);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function deleteProduct($product_id) {
  global $conn;
  $stmt = $conn->prepare("DELETE FROM `products` WHERE `id` = ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function getOrderHistory($user_id) {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM `orders` WHERE `user_id` = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result =$stmt->get_result();
  $orders = array();
  while ($row = $result->fetch_assoc()) {
     $orders[] = $row;
  }
  return $orders;
}

function createOrder($user_id, $product_ids) {
  global $conn;
  $stmt = $conn->prepare("INSERT INTO `orders` (`user_id`, `product_ids`) VALUES (?, ?)");
  $stmt->bind_param("is", $user_id, $product_ids);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

function getUserProfile($user_id) {
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM `user_profile` WHERE `user_id` = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $profile = $result->fetch_assoc();
  return $profile;
}

function updateUserProfile($user_id, $name, $email, $address) {
  global $conn;
  $stmt = $conn->prepare("UPDATE `user_profile` SET `name` = ?, `email` = ?, `address` = ? WHERE `user_id` = ?");
  $stmt->bind_param("sssi", $name, $email, $address, $user_id);
  $stmt->execute();
  return $stmt->affected_rows > 0;
}

?>