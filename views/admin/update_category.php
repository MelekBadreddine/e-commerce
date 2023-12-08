<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $category_id = $_POST['category_id'];
   $category_name = $_POST['category_name'];
   $category_name = filter_var($category_name, FILTER_SANITIZE_STRING);

   $update_category = $conn->prepare("UPDATE `category` SET category_name = ? WHERE code = ?");
   $update_category->execute([$category_name, $category_id]);

   $message[] = 'Category updated successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Category</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-category">

   <h1 class="heading">Update Category</h1>

   <?php
      $update_id = $_GET['update'];
      $select_categories = $conn->prepare("SELECT * FROM `category` WHERE code = ?");
      $select_categories->execute([$update_id]);

      if($select_categories->rowCount() > 0){
         while($fetch_category = $select_categories->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post">
      <input type="hidden" name="category_id" value="<?= $fetch_category['code']; ?>">
      <span>Update Category Name</span>
      <input type="text" name="category_name" required class="box" maxlength="100" placeholder="Enter category name" value="<?= $fetch_category['name']; ?>">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="Update">
         <a href="categories.php" class="option-btn">Go Back</a>
      </div>
   </form>
   
   <?php
         }
      } else {
         echo '<p class="empty">No category found!</p>';
      }
   ?>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
