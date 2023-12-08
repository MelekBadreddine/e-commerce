<?php

class ProductsModel {

    public function getProductsByCategory($categoryName) {
        global $conn;

        // Use a LIKE query to find products with names resembling the category
        $sql = "SELECT * FROM products WHERE name LIKE :categoryName";

        $stmt = $conn->prepare($sql);

        // Use '%' around the category name to match any occurrence in the product names
        $categoryName = "%" . $categoryName . "%";
        $stmt->bindParam(":categoryName", $categoryName, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductById($product_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function getAllProducts() {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function createProduct($name, $price, $categoryName) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO products (name, price, category_id) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $price, PDO::PARAM_INT);
        $stmt->bindParam(3, $categoryName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function updateProduct($product_id, $name, $price, $categoryName) {
        global $conn;
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, category_id = ? WHERE id = ?");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $price, PDO::PARAM_INT);
        $stmt->bindParam(3, $categoryName, PDO::PARAM_STR);
        $stmt->bindParam(4, $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function deleteProduct($product_id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Add other methods related to products here...

}
?>