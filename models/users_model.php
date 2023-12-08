<?php

class UsersModel {

    public function getUserById($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return $user;
    }

    public function registerUser($username, $password) {
        global $conn;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function loginUser($username, $password) {
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

    // Add other methods related to users here...

}

?>
