<?php

include '../models/products_model.php';

class ProductController {
    private $productsModel;

    public function __construct() {
        $this->productsModel = new ProductsModel();
    }

    public function getProductsByCategory($category_id) {
        return $this->productsModel->getProductsByCategory($category_id);
    }

    public function getProductById($product_id) {
        return $this->productsModel->getProductById($product_id);
    }

    public function addProduct($name, $details, $price, $image_01, $image_02, $image_03) {
        return $this->productsModel->addProduct($name, $details, $price, $image_01, $image_02, $image_03);
    }

    public function updateProduct($product_id, $name, $details, $price, $image_01, $image_02, $image_03) {
        return $this->productsModel->updateProduct($product_id, $name, $details, $price, $image_01, $image_02, $image_03);
    }

    public function deleteProduct($product_id) {
        return $this->productsModel->deleteProduct($product_id);
    }

    public function getAllProducts() {
      return $this->productsModel->getAllProducts();
  }

    // Add other product-related methods...

}

?>