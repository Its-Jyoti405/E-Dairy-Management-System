<?php
include 'config.php'; session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){header('location:login.php');}
if(isset($_POST['update_cart'])){
  $cid=$_POST['cart_id'];$cq=$_POST['cart_quantity'];$cmq=$_POST['cart_milk_quantity'];
  mysqli_query($conn,"UPDATE `cart` SET quantity='$cq',milk_quantity='$cmq' WHERE id='$cid'") or die('query failed');
  $message[]='Cart updated successfully!';
}
if(isset($_GET['delete'])){$did=$_GET['delete'];mysqli_query($conn,"DELETE FROM `cart` WHERE id='$did'") or die('query failed');header('location:cart.php');}
if(isset($_GET['delete_all'])){mysqli_query($conn,"DELETE FROM `cart` WHERE user_id='$user_id'") or die('query failed');header('location:cart.php');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>My Cart — Milky</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="heading"><h3>Shopping Cart</h3><p><a href="home.php">Home</a> / Cart</p></div>
<section class="shopping-cart">
  <div class="box-container">
    <?php
    $grand=0;
    $sc=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
    if(mysqli_num_rows($sc)>0){
      while($c=mysqli_fetch_assoc($sc)){
        $ml = (int)($c['milk_quantity'] ?? 1000);
        if ($ml == 0) $ml = 1000; // default to full base size
        
        $price_per_item = $c['price'] * ($ml / 1000);
        $sub = $c['quantity'] * $price_per_item;
        $grand += $sub;
    ?>
    <div class="box reveal">
      <a href="cart.php?delete=<?php echo $c['id']; ?>" class="fa-times fas" title="Remove item" onclick="return confirm('Remove this item from cart?');"></a>
      <img src="uploaded_img/<?php echo $c['image']; ?>" alt="<?php echo htmlspecialchars($c['name']); ?>">
      <div class="name"><?php echo htmlspecialchars($c['name']); ?></div>
      <div class="price">&#8377;<?php echo $c['price']; ?> (Base)</div>
      <form action="" method="post" class="cart-controls">
        <input type="hidden" name="cart_id" value="<?php echo $c['id']; ?>">
        <input type="number" min="1" name="cart_quantity" value="<?php echo $c['quantity']; ?>" title="Quantity">
        <select name="cart_milk_quantity">
          <option value="1000" <?php if($ml==1000)echo 'selected'; ?>>1 Unit/1L/1Kg</option>
          <option value="500" <?php if($ml==500)echo 'selected'; ?>>Half (500ml/500g)</option>
          <option value="250" <?php if($ml==250)echo 'selected'; ?>>Quarter (250ml/250g)</option>
        </select>
        <input type="submit" name="update_cart" value="Update" class="option-btn">
      </form>
      <div class="sub-total">Subtotal: <span>&#8377;<?php echo number_format($sub,2); ?></span></div>
    </div>
    <?php }} else{echo '<p class="empty">Your cart is empty. <a href="shop.php" style="color:var(--amber-dark);font-weight:600;">Start shopping</a></p>';} ?>
  </div>
  <?php if($grand>0): ?>
  <div class="cart-summary reveal">
    <p class="grand">Grand Total: <span>&#8377;<?php echo number_format($grand,2); ?></span></p>
    <div class="actions">
      <a href="cart.php?delete_all" class="delete-btn" onclick="return confirm('Remove all items from cart?');"><i class="fas fa-trash"></i> Clear Cart</a>
      <a href="shop.php" class="option-btn"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
      <a href="checkout.php" class="btn"><i class="fas fa-credit-card"></i> Proceed to Checkout</a>
    </div>
  </div>
  <?php else: ?>
  <div class="cart-summary reveal" style="text-align:center">
    <a href="shop.php" class="option-btn"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
  </div>
  <?php endif; ?>
</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body></html>
