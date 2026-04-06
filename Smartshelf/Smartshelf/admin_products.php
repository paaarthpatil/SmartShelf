<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];

   if(!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK){
      $message[] = 'please choose an image, crop it, then add the product';
   }elseif((int)$_FILES['image']['size'] > 2000000){
      $message[] = 'image size is too large';
   }else{
      $upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'uploaded_img';
      if(!is_dir($upload_dir)){
         @mkdir($upload_dir, 0777, true);
      }

      $tmp = $_FILES['image']['tmp_name'];
      $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
      if(!in_array($ext, ['jpg','jpeg','png','gif','webp'], true)){
         $ext = 'jpg';
      }
      $image = uniqid('product_', true).'.'.$ext;
      $image_abs_path = $upload_dir . DIRECTORY_SEPARATOR . $image;

      $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

      if(mysqli_num_rows($select_product_name) > 0){
         $message[] = 'product name already added';
      }elseif(!is_uploaded_file($tmp) || !is_dir($upload_dir) || !move_uploaded_file($tmp, $image_abs_path)){
         $message[] = 'failed to save image file';
      }else{
         $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');
         if($add_product_query){
            $message[] = 'product added successfully!';
         }else{
            @unlink($image_abs_path);
            $message[] = 'product could not be added!';
         }
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_old_image = $_POST['update_old_image'];

   if(isset($_FILES['update_image']) && $_FILES['update_image']['error'] === UPLOAD_ERR_OK && !empty($_FILES['update_image']['name'])){
      $upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'uploaded_img';
      if(!is_dir($upload_dir)){
         @mkdir($upload_dir, 0777, true);
      }

      $update_image_size = (int)$_FILES['update_image']['size'];
      $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         $ext = strtolower(pathinfo($_FILES['update_image']['name'], PATHINFO_EXTENSION));
         if(!in_array($ext, ['jpg','jpeg','png','gif','webp'], true)){
            $ext = 'jpg';
         }
         $update_image = uniqid('product_', true).'.'.$ext;
         $update_abs_path = $upload_dir . DIRECTORY_SEPARATOR . $update_image;
         if(is_uploaded_file($update_image_tmp_name) && is_dir($upload_dir) && move_uploaded_file($update_image_tmp_name, $update_abs_path)){
            mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            $old_abs_path = $upload_dir . DIRECTORY_SEPARATOR . $update_old_image;
            if(!empty($update_old_image) && file_exists($old_abs_path)){
               unlink($old_abs_path);
            }
         }else{
            $message[] = 'failed to save new image file';
         }
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

   <!-- cropper.js (image crop before upload) -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">shop products</h1>

   <form id="add-product-form" action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" id="product-image-input" name="image" accept="image/jpeg,image/jpg,image/png" class="box">
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">RS.<?php echo $fetch_products['price']; ?>/-</div>
         <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="file" id="update-product-image-input" class="box" name="update_image" accept="image/jpeg,image/jpg,image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<div id="image-crop-modal" class="crop-modal" aria-hidden="true" role="dialog" aria-labelledby="crop-modal-title">
   <div class="crop-modal__backdrop" aria-hidden="true"></div>
   <div class="crop-modal__dialog">
      <h3 id="crop-modal-title">Crop image</h3>
      <p class="crop-modal__hint">Crop is fixed to a 2:3 book-cover shape. Adjust position, then use the cropped image.</p>
      <div class="crop-modal__img-wrap">
         <img id="crop-modal-img" src="" alt="Image to crop">
      </div>
      <div class="crop-modal__actions">
         <button type="button" id="crop-modal-cancel" class="option-btn">Cancel</button>
         <button type="button" id="crop-modal-apply" class="btn">Use cropped image</button>
      </div>
   </div>
</div>







<!-- custom admin js file link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="js/admin_script.js"></script>
<script src="js/admin_product_crop.js"></script>

</body>
</html>