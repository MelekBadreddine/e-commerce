<?php
include 'components/connect.php';

if (isset($_POST['search_box'])) {
    $search_box = '%' . $_POST['search_box'] . '%'; // Adding '%' for SQL LIKE

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ?");
    $select_products->execute([$search_box]);

    if ($select_products->rowCount() > 0) {
        echo '<ul class="list-group">';
        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            echo '<li class="list-group-item">' . $fetch_product['name'] . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p class="empty">No products found!</p>';
    }
} else {
    echo '<p class="empty">Invalid request!</p>';
}
?>
