<?php

include '../models/users_model.php';

class UserController {
    private $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();
    }

    public function getUserById($user_id) {
        return $this->usersModel->getUserById($user_id);
    }

    public function registerUser($username, $password) {
        return $this->usersModel->registerUser($username, $password);
    }

    public function loginUser($username, $password) {
        return $this->usersModel->loginUser($username, $password);
    }

    public function updateUserProfile($user_id, $name, $email, $address) {
        return $this->usersModel->updateUserProfile($user_id, $name, $email, $address);
    }

    // Add other user-related methods...

}

?>
