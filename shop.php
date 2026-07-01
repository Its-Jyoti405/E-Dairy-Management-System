<?php
include 'config.php'; session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){header('location:login.php');}
if(isset($_POST['add_to_cart'])){
  $pn=$_POST['product_name'];$pp=$_POST['product_price'];
  $pi=$_POST['product_image'];$pq=$_POST['product_quantity'];
  $ml=$_POST['milk_quantity']??'1000';

  $check_avail = mysqli_query($conn, "SELECT availability FROM products WHERE name='$pn'");
  $avail_data = mysqli_fetch_assoc($check_avail);
  if ($avail_data && isset($avail_data['availability']) && $avail_data['availability'] == 0) {
      $message[] = 'This product is currently out of stock and cannot be added to cart!';
  } else {
      $chk=mysqli_query($conn,"SELECT * FROM `cart` WHERE name='$pn' AND user_id='$user_id'") or die('query failed');
      if(mysqli_num_rows($chk)>0){$message[]='This item is already in your cart.';}
      else{mysqli_query($conn,"INSERT INTO `cart`(user_id,name,price,quantity,image,milk_quantity) VALUES('$user_id','$pn','$pp','$pq','$pi','$ml')") or die('query failed');$message[]='Product added to cart!';}
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="description" content="Shop fresh dairy products at Milky — milk, paneer, butter, curd and more.">
  <title>Shop — Milky Fresh Dairy</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <style>.disabled-image{filter:blur(3px) grayscale(50%)}</style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="heading"><h3>Our Shop</h3><p><a href="home.php">Home</a> / Shop</p></div>
<section class="products" style="background:var(--light-bg)">
  <h2 class="section-title reveal">All Products</h2>
  <p class="section-sub reveal">Pure, farm-fresh dairy sourced directly from our trusted farming partners.</p>
  <div class="box-container">
    <?php
    $rows=mysqli_query($conn,"SELECT * FROM `products`") or die('query failed');
    if(mysqli_num_rows($rows)>0){
      while($p=mysqli_fetch_assoc($rows)){
        $avail=isset($p['availability'])?$p['availability']:1;
    ?>
    <form action="" method="post" class="box reveal">
      <div class="image-wrap">
        <img class="image <?php echo $avail?'':'disabled-image'; ?>" src="uploaded_img/<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
        <div class="price-badge">&#8377;<?php echo $p['price']; ?></div>
        <span class="avail-badge <?php echo $avail?'tag-green':'tag-red'; ?>">
          <i class="fas <?php echo $avail?'fa-check-circle':'fa-times-circle'; ?>"></i>
          <?php echo $avail?'In Stock':'Sold Out'; ?>
        </span>
      </div>
      <div class="card-body">
        <div class="prod-name"><?php echo htmlspecialchars($p['name']); ?></div>
        <label><i class="fas fa-boxes"></i> Quantity</label>
        <input type="number" min="1" name="product_quantity" value="1" class="qty">
        <label><i class="fas fa-weight-hanging"></i> Select Size</label>
        <select name="milk_quantity">
          <option value="1000">1 Unit / 1L / 1Kg</option>
          <option value="500">Half (500ml/500g)</option>
          <option value="250">Quarter (250ml/250g)</option>
        </select>
        <input type="hidden" name="product_name"  value="<?php echo $p['name']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $p['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $p['image']; ?>">
        <?php $d=$avail?'':'disabled'; ?>
        <input type="submit" value="<?php echo $avail?'Add to Cart':'Unavailable'; ?>" name="add_to_cart" class="btn <?php echo $d; ?>" <?php echo $d; ?> style="margin-top:.5rem">
      </div>
    </form>
    <?php }}else{echo '<p class="empty">No products available yet.</p>';} ?>
  </div>
</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body></html>
