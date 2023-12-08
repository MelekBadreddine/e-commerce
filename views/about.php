<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include '../models/model.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/style.css">

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .swiper-slide.slide {
         display: flex;
         flex-direction: column;
         justify-content: space-between;
         align-items: center;
         height: auto;
         padding: 20px;
         text-align: center;
      }

      .swiper-slide.slide p {
         margin-bottom: 15px;
      }
  </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="assets/images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam veritatis minus et similique doloribus? Harum molestias tenetur eaque illum quas? Obcaecati nulla in itaque modi magnam ipsa molestiae ullam consequuntur.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">client's reviews</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="assets/images/pic-1.png" alt="">
         <p>I recently purchased a laptop from ElectroSphere and I’m extremely satisfied with my purchase. The laptop is high-performance and perfect for my needs. The customer service was also top-notch. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Saber Rebai</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="assets/images/pic-2.png" alt="">
         <p>ElectroSphere is my go-to for all my electronic needs. I bought a smartphone and a washing machine from them and both are working flawlessly. Their products are reliable and their service is unbeatable.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Najla Ben Abdallah</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="assets/images/pic-3.png" alt="">
         <p>I bought a fridge from ElectroSphere and it’s the best investment I’ve made. The fridge is energy-efficient and spacious. ElectroSphere’s delivery and installation service was prompt and hassle-free.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Balti</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="assets/images/pic-4.png" alt="">
         <p>ElectroSphere offers a wide range of TVs and I found one that fits perfectly in my living room. The picture quality is amazing and the sound is just perfect. I’m very happy with my purchase</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Youssef Msakni</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="assets/images/pic-5.png" alt="">
         <p>I purchased a camera from ElectroSphere for my photography hobby and I’m impressed with the quality of the product. The camera captures stunning photos and is easy to use. Kudos to ElectroSphere for their excellent range of products.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ons Jabeur</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="assets/images/pic-6.png" alt="">
         <p>ElectroSphere is a one-stop-shop for all electronic appliances. I furnished my entire house with their products and each one of them is working perfectly. Their after-sales service is commendable. Highly recommended!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Yassine Ben Gamra</h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>