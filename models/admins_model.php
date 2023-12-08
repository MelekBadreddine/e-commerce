<?php

class AdminsModel {

    // Retrieve an admin by ID
    public function getAdminById($admin_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM `admins` WHERE `id` = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        return $admin;
    }

    // Delete an admin by ID
    public function deleteAdmin($admin_id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM `admins` WHERE `id` = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Retrieve all users
    public function getAllUsers() {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM `users`");
        $stmt->execute();
        $result = $stmt->get_result();
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    // Delete a user by ID
    public function deleteUser($user_id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM `users` WHERE `id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Add a new product
    public function addProduct($name, $price, $category_id) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO `products` (`name`, `price`, `category_id`) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $name, $price, $category_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Delete a product by ID
    public function deleteProduct($product_id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM `products` WHERE `id` = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Add other methods related to admins here...

}

?>
