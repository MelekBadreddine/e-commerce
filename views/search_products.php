<?php
include 'components/connect.php'; // Include your database connection

// Check if search value exists
if (isset($_POST['search_box'])) {
    $search_box = $_POST['search_box']; // Get the search value from AJAX

    // Prepare SQL statement to search products based on name
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ?"); 
    $select_products->execute(["%$search_box%"]);

    // Check if products found
    if ($select_products->rowCount() > 0) {
        // Loop through each product and output HTML structure
        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            // Output the HTML structure for each product
            ?>
            <form action="" method="post" class="box">
               <!-- ... (other input fields or product information) ... -->
               <div class="name"><?= $fetch_product['name']; ?></div>
               <div class="flex">
                  <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
                  <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
               </div>
               <input type="submit" value="add to cart" class="btn" name="add_to_cart">
            </form>
            <?php
        }
    } else {
        echo '<p class="empty">No products found!</p>';
    }
}
?>
