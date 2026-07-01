<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){ header('location:login.php'); }
if(isset($_POST['add_to_cart'])){
  $pn = $_POST['product_name'];  $pp = $_POST['product_price'];
  $pi = $_POST['product_image']; $pq = $_POST['product_quantity'];
  $ml = $_POST['milk_quantity'] ?? '1000';
  
  $check_avail = mysqli_query($conn, "SELECT availability FROM products WHERE name='$pn'");
  $avail_data = mysqli_fetch_assoc($check_avail);
  
  if ($avail_data && isset($avail_data['availability']) && $avail_data['availability'] == 0) {
      $message[] = 'This product is currently out of stock and cannot be added to cart!';
  } else {
      $chk= mysqli_query($conn,"SELECT * FROM `cart` WHERE name='$pn' AND user_id='$user_id'") or die('query failed');
      if(mysqli_num_rows($chk)>0){ $message[]='Already in your cart!'; }
      else{ mysqli_query($conn,"INSERT INTO `cart`(user_id,name,price,quantity,image,milk_quantity) VALUES('$user_id','$pn','$pp','$pq','$pi','$ml')") or die('query failed'); $message[]='Product added to cart!'; }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="description" content="Milky — Farm-fresh dairy products delivered to your home every morning.">
  <title>Milky — Farm Fresh Dairy Delivered Daily</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<!-- HERO -->
<section class="home">
  <div class="content">
    <div class="eyebrow"><i class="fas fa-leaf"></i> 100% Natural &amp; Farm Fresh</div>
    <h3>Pure Dairy,<br>Delivered <em>Every Morning</em>.</h3>
    <p>Experience the richness of farm-fresh milk, paneer, and curd — sourced directly from our trusted dairy farmers and delivered to your table within hours.</p>
    <div class="home-btns">
      <a href="shop.php" class="btn"><i class="fas fa-store"></i> Shop Now</a>
      <a href="about.php" class="white-btn"><i class="fas fa-play-circle"></i> Our Story</a>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats-bar">
  <div class="container">
    <div class="stat-item reveal">
      <div class="stat-icon"><i class="fas fa-users"></i></div>
      <div class="stat-num">10K+</div>
      <div class="stat-label">Happy Customers</div>
    </div>
    <div class="stat-item reveal">
      <div class="stat-icon"><i class="fas fa-tractor"></i></div>
      <div class="stat-num">500+</div>
      <div class="stat-label">Farming Partners</div>
    </div>
    <div class="stat-item reveal">
      <div class="stat-icon"><i class="fas fa-award"></i></div>
      <div class="stat-num">100%</div>
      <div class="stat-label">Pure &amp; Natural</div>
    </div>
    <div class="stat-item reveal">
      <div class="stat-icon"><i class="fas fa-truck"></i></div>
      <div class="stat-num">24/7</div>
      <div class="stat-label">Fresh Delivery</div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-it-works">
  <h2 class="section-title reveal">How It Works</h2>
  <p class="section-sub reveal">From our farm to your family, every step is fresh and transparent.</p>
  <div class="steps">
    <div class="step-card reveal">
      <span class="step-number">1</span>
      <div class="icon-wrap"><i class="fas fa-search"></i></div>
      <h4>Browse &amp; Choose</h4>
      <p>Explore our wide range of fresh dairy products and select what you need for your family.</p>
    </div>
    <div class="step-card reveal">
      <span class="step-number">2</span>
      <div class="icon-wrap"><i class="fas fa-shopping-cart"></i></div>
      <h4>Add to Cart</h4>
      <p>Choose quantities and milk volumes, then proceed to our simple secure checkout.</p>
    </div>
    <div class="step-card reveal">
      <span class="step-number">3</span>
      <div class="icon-wrap"><i class="fas fa-truck"></i></div>
      <h4>Fast Delivery</h4>
      <p>We collect fresh produce at dawn and deliver to your door by morning — every day.</p>
    </div>
    <div class="step-card reveal">
      <span class="step-number">4</span>
      <div class="icon-wrap"><i class="fas fa-heart"></i></div>
      <h4>Enjoy Freshness</h4>
      <p>Savour the genuine taste of pure, natural dairy straight from the farm.</p>
    </div>
  </div>
</section>

<!-- PRODUCTS -->
<section class="products">
  <h2 class="section-title reveal">Fresh Products</h2>
  <p class="section-sub reveal">Hand-picked, farm-fresh dairy delivered within hours of collection.</p>
  <div class="box-container">
    <?php
    $rows = mysqli_query($conn,"SELECT * FROM `products` LIMIT 8") or die('query failed');
    if(mysqli_num_rows($rows)>0){
      while($p=mysqli_fetch_assoc($rows)){
        $avail = $p['availability'] ?? 1;
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
    <?php }}else{ echo '<p class="empty">No products yet. Please check back soon.</p>'; } ?>
  </div>
  <div style="text-align:center;margin-top:4rem">
    <a href="shop.php" class="option-btn"><i class="fas fa-th-large"></i> View All Products</a>
  </div>
</section>

<!-- ABOUT STRIP -->
<section class="about-strip">
  <div class="flex">
    <div class="image"><img src="images/about-img.png" alt="Dairy farm"></div>
    <div class="content reveal">
      <div class="pre-label"><i class="fas fa-seedling"></i> Our Story</div>
      <h3>Straight From Farm<br>to Your Table</h3>
      <p>We believe in the power of pure, natural dairy. Our cows graze on lush green meadows and our products reach you within hours — no preservatives, no compromise on quality.</p>
      <a href="about.php" class="white-btn" style="margin-top:1rem"><i class="fas fa-arrow-right"></i> Learn More</a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials">
  <h2 class="section-title reveal">What Our Customers Say</h2>
  <p class="section-sub reveal">Real reviews from families who trust our dairy every day.</p>
  <div class="box-container">
    <div class="testi-box reveal">
      <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
      <p>"The milk quality is exceptional — so fresh and creamy. My family has been using Milky for 6 months and we won't switch to anything else."</p>
      <div class="author"><div class="avatar">P</div><div><h4>Priya Sharma</h4><span>Nashik, Maharashtra</span></div></div>
    </div>
    <div class="testi-box reveal">
      <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
      <p>"Delivery is always on time, every single morning. The paneer is absolutely fresh and the billing system is very transparent."</p>
      <div class="author"><div class="avatar">R</div><div><h4>Rajesh Patil</h4><span>Pune, Maharashtra</span></div></div>
    </div>
    <div class="testi-box reveal">
      <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
      <p>"Excellent products at fair prices. You can literally taste the difference between supermarket milk and Milky's farm-fresh variety."</p>
      <div class="author"><div class="avatar">A</div><div><h4>Anjali Desai</h4><span>Mumbai, Maharashtra</span></div></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="home-contact">
  <div class="content">
    <h3>Have Questions?<br>We Are Here to Help.</h3>
    <p>Our dairy experts are available six days a week to help you choose the right products and delivery plan for your household.</p>
    <a href="contact.php" class="white-btn"><i class="fas fa-paper-plane"></i> Contact Us</a>
  </div>
</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body></html>