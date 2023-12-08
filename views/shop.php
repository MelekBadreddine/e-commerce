<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

include 'components/wishlist_cart.php';
include '../controllers/product_controller.php'; // Include ProductController

// Create an instance of ProductController
$productController = new ProductController();

// Fetch all products initially
$allProducts = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>
   
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/style.css">

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
         $('#search_box').on('input', function() {
            var searchValue = $(this).val().toLowerCase();

            // Loop through all products and show/hide based on search input
            $('.product-item').each(function() {
               var productName = $(this).find('.name').text().toLowerCase();
               if (productName.includes(searchValue)) {
                  $(this).show();
               } else {
                  $(this).hide();
               }
            });
         });
      });
   </script>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="search-form">
   <input type="text" id="search_box" placeholder="search here..." maxlength="100" class="box" required>
   <button type="submit" class="fas fa-search" name="search_btn"></button>
</section>

<h1 class="heading">latest products</h1>

<section class="products" style="padding-top: 0;">
   <div class="box-container">
      <!-- Products will be dynamically loaded here -->
      <?php foreach ($allProducts as $product): ?>
         <form action="" method="post" class="box product-item">
            <input type="hidden" name="pid" value="<?= $product['id']; ?>">
            <input type="hidden" name="name" value="<?= $product['name']; ?>">
            <input type="hidden" name="price" value="<?= $product['price']; ?>">
            <input type="hidden" name="image" value="<?= $product['image_01']; ?>">
            <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
            <a href="quick_view.php?pid=<?= $product['id']; ?>" class="fas fa-eye"></a>
            <img src="<?= $product['image_01']; ?>" alt="">
            <div class="name"><?= $product['name']; ?></div>
            <div class="flex">
               <div class="price"><span>$</span><?= $product['price']; ?><span>/-</span></div>
               <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
            <input type="submit" value="add to cart" class="btn" name="add_to_cart">
         </form>
      <?php endforeach; ?>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>






