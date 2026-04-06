<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="resources/about/hero-illustration.svg" alt="Illustration of books and reading">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>We stock a wide range of books with honest pricing and clear product information. Search and add to cart in seconds, then pay the way you prefer—including cash on delivery where available.</p>
         <p>Your orders are tracked from placement to delivery, and our team is here if anything goes wrong. We believe buying books online should feel as trustworthy as walking into your favourite shop.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="resources/reviews/reviewer-01.svg" alt="">
         <p>Ordered three novels for our book club—packaging was solid and the parcel arrived two days before the estimated date.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ananya Sharma</h3>
      </div>

      <div class="box">
         <img src="resources/reviews/reviewer-02.svg" alt="">
         <p>Found my semester textbooks without hunting across shops. Checkout was quick and I paid less than at the campus store.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Rohan Mehta</h3>
      </div>

      <div class="box">
         <img src="resources/reviews/reviewer-03.svg" alt="">
         <p>Support helped me correct my shipping address the same day. Small thing, but it saved me a lot of stress.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Priya Nair</h3>
      </div>

      <div class="box">
         <img src="resources/reviews/reviewer-04.svg" alt="">
         <p>Great mix of Indian languages and translations. Finally one place where I can browse regional fiction easily.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Vikram Singh</h3>
      </div>

      <div class="box">
         <img src="resources/reviews/reviewer-05.svg" alt="">
         <p>Smooth experience from cart to delivery. My book arrived with no dents—exactly what you want when you order hardcovers.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Neha Kapoor</h3>
      </div>

      <div class="box">
         <img src="resources/reviews/reviewer-06.svg" alt="">
         <p>Bought gifts for family during the sale. Clear order status emails and on-time delivery—will use again.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Arjun Desai</h3>
      </div>

   </div>

</section>

<section class="authors">

   <h1 class="title">featured authors</h1>

   <div class="box-container">

      <div class="box">
         <img src="resources/authors/author-01.svg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Arundhati Roy</h3>
      </div>

      <div class="box">
         <img src="resources/authors/author-02.svg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Chetan Bhagat</h3>
      </div>

      <div class="box">
         <img src="resources/authors/author-03.svg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Vikram Seth</h3>
      </div>

      <div class="box">
         <img src="resources/authors/author-04.svg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Amish Tripathi</h3>
      </div>

      <div class="box">
         <img src="resources/authors/author-05.svg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Ruskin Bond</h3>
      </div>

      <div class="box">
         <img src="resources/authors/author-06.svg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Jhumpa Lahiri</h3>
      </div>

   </div>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>