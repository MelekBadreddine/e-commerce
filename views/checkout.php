<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

include '../controllers/cart_controller.php';

// Fetch cart items and calculate grand total
$grand_total = 0;
$cart_items = []; // Initialize an empty array to store cart items

$cartController = new CartController();
$cartItems = $cartController->getCartItems($user_id);

if (!empty($cartItems)) {
    foreach ($cartItems as $cartItem) {
        $cart_items[] = $cartItem['name'] . ' (' . '$' . $cartItem['price'] . ' x ' . $cartItem['quantity'] . ') - ';
        $total_products = implode($cart_items);
        $grand_total += ($cartItem['price'] * $cartItem['quantity']);
    }
}

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      require_once('fpdf/fpdf.php'); // Include FPDF library

      // Inside the block where you're generating the PDF
      $pdf = new FPDF();
      $pdf->AddPage();
      $pdf->SetFillColor(230, 230, 230); // Background color for title
      $pdf->SetFont('Arial', 'B', 16);

      // Title with background color
      $pdf->Cell(190, 10, 'Order Details', 1, 1, 'C', true);

      $pdf->SetFont('Arial', '', 12);
      $pdf->SetTextColor(0, 0, 0); // Text color

      // Order information
      $pdf->Cell(40, 10, 'Customer Name:', 0, 0, 'R');
      $pdf->Cell(150, 10, $name, 0, 1);

      $pdf->Cell(40, 10, 'Contact Number:', 0, 0, 'R');
      $pdf->Cell(150, 10, $number, 0, 1);

      $pdf->Cell(40, 10, 'Email:', 0, 0, 'R');
      $pdf->Cell(150, 10, $email, 0, 1);

      $pdf->Cell(40, 10, 'Payment Method:', 0, 0, 'R');
      $pdf->Cell(150, 10, $method, 0, 1);

      $pdf->Cell(40, 10, 'Delivery Address:', 0, 0, 'R');
      $pdf->MultiCell(150, 10, $address);

      // Add ordered items
      $pdf->Ln();
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(0, 10, 'Ordered Items:', 0, 1);

      $pdf->SetFont('Arial', '', 12);
      foreach ($cartItems as $cartItem) {
          $pdf->Cell(0, 10, $cartItem['name'] . ' (' . '$' . $cartItem['price'] . ' x ' . $cartItem['quantity'] . ')');
          $pdf->Ln();
      }

      // Add total price
      $pdf->Ln();
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(0, 10, 'Total Price: $' . $grand_total, 0, 1);

      // Output the PDF as a download
      $pdfFilePath = 'order_details.pdf'; // Path to save the PDF
      $pdf->Output($pdfFilePath, 'F'); // Save the PDF file

      // Inside the block where you handle successful order placement
      echo "<script>
      alert('Order placed successfully!'); 
      window.location.href = 'components/download_pdf.php?file=../$pdfFilePath';
      setTimeout(function() {
          window.location.href = 'orders.php';
      }, 1000); // Delay the redirection by 1 second (1000 milliseconds) after initiating the PDF download
      </script>";
    } else {
      echo "<script>alert('Your cart is empty'); window.location.reload();</script>";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/style.css">

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
      
      $grand_total = 0;
      $cart_items = []; // Initialize an empty array to store cart items

      $cartController = new CartController();
      $cartItems = $cartController->getCartItems($user_id);

      if (!empty($cartItems)) {
          foreach ($cartItems as $cartItem) {
              $cart_items[] = $cartItem['name'] . ' (' . '$' . $cartItem['price'] . ' x ' . $cartItem['quantity'] . ') - ';
              $total_products = implode($cart_items);
              $grand_total += ($cartItem['price'] * $cartItem['quantity']);
      ?>
              <p><?= $cartItem['name']; ?> <span>(<?= '$' . $cartItem['price'] . '/- x ' . $cartItem['quantity']; ?>)</span></p>
      <?php
          }
      } else {
          echo '<p class="empty">Your cart is empty!</p>';
      }
      ?>

         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">grand total : <span>$<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paytm">paytm</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. Sfax" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. Sfax" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. Tunisia" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Place Order">

   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>