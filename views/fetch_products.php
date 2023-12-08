<?php
include 'components/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['search_term'];

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ?");
    $select_products->execute(["%$searchTerm%"]);
    $products = $select_products->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
} else {
    echo json_encode([]);
}
?>
