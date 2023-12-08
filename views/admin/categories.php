<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

// Add category
if(isset($_POST['add_category'])){

   $name = $_POST['name'];

   $stmt = $conn->prepare("SELECT * FROM category WHERE name = ?");
   $stmt->execute([$name]);
   
   if($stmt->rowCount() > 0){
      $msg[] = 'Category already exists!';    
   }else{
      $stmt = $conn->prepare("INSERT INTO category(name) VALUES(?)");
      $res = $stmt->execute([$name]);
      if($res){
         $msg[] = 'Category added successfully!';
      }else{
         $msg[] = 'Failed to add category!';
      }
   }
}

// Delete category
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_cate = $conn->prepare("DELETE FROM category WHERE code = ?");
   $delete_cate->execute([$delete_id]);
   header('location:categories.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Categories</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

<h1 class="heading">Manage Categories</h1>

<form action="" method="post" enctype="multipart/form-data">
   
   <div class="form-group">
      <label>Category Name</label>
      <input type="text" name="name" required placeholder="Enter category name" class="box" maxlength="100">
   </div>

   <input type="submit" value="Add Category" onclick="return confirm('Add this category?');" class="btn" name="add_category">

</form>

</section>

<section class="show-products">

   <h1 class="heading"> Categories Added</h1>

   <div class="box-container">

      <?php
         $select_categories = $conn->prepare("SELECT * FROM category"); 
         $select_categories->execute();
         if($select_categories->rowCount() > 0){
            while($fetch_categories = $select_categories->fetch(PDO::FETCH_ASSOC)){
      ?>
         <div class="box">
            <p><?=$fetch_categories['name'];?></p>
            <div class="flex-btn">
               <a href="update_category.php?update=<?=$fetch_categories['code'];?>" class="option-btn">update</a>
               <a href="categories.php?delete=<?=$fetch_categories['code'];?>" onclick="return confirm('Delete this category?');" class="delete-btn">delete</a>
            </div>
         </div>
      <?php
            }
         }else{
            echo '<p class="empty">no categories added yet!</p>';
         }
      ?>
   </div>

</section>
<script src="../assets/js/admin_script.js"></script>
</body>
</html>