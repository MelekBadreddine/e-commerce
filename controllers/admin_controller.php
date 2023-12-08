<?php

include '../models/admins_model.php';

class AdminController {
    private $adminsModel;

    public function __construct() {
        $this->adminsModel = new AdminsModel();
    }

    public function getAdminById($admin_id) {
        return $this->adminsModel->getAdminById($admin_id);
    }

    public function deleteAdmin($admin_id) {
        return $this->adminsModel->deleteAdmin($admin_id);
    }

    public function getAllUsers() {
        return $this->adminsModel->getAllUsers();
    }

    public function deleteUser($user_id) {
        return $this->adminsModel->deleteUser($user_id);
    }

    public function addProduct($name, $details, $price, $image_01, $image_02, $image_03) {
        return $this->adminsModel->addProduct($name, $details, $price, $image_01, $image_02, $image_03);
    }

    public function deleteProduct($product_id) {
        return $this->adminsModel->deleteProduct($product_id);
    }

    // Add other admin-related methods...

}

?>
