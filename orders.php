<?php
include 'config.php'; session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){header('location:login.php');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>My Orders — Milky</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="heading"><h3>My Orders</h3><p><a href="home.php">Home</a> / Orders</p></div>
<section class="placed-orders">
  <h2 class="section-title reveal">Order History</h2>
  <p class="section-sub reveal">All your past and current orders in one place.</p>
  <div class="orders-list">
    <?php
    $oq=mysqli_query($conn,"SELECT * FROM `orders` WHERE user_id='$user_id' ORDER BY id DESC") or die('query failed');
    if(mysqli_num_rows($oq)>0){
      while($o=mysqli_fetch_assoc($oq)){
        $sc=($o['payment_status']=='pending')?'s-pending':'s-complete';
        $si=($o['payment_status']=='pending')?'fa-clock':'fa-check-circle';
    ?>
    <div class="order-card reveal">
      <div class="order-card-head">
        <div class="order-meta">
          <div class="order-date"><i class="fas fa-calendar-alt"></i> <?php echo $o['placed_on']; ?></div>
          <div class="order-id">Order #<?php echo str_pad($o['id'],5,'0',STR_PAD_LEFT); ?></div>
        </div>
        <span class="status-pill <?php echo $sc; ?>"><i class="fas <?php echo $si; ?>"></i> <?php echo ucfirst($o['payment_status']); ?></span>
      </div>
      <div class="order-body">
        <div class="odetail"><strong>Customer</strong><?php echo htmlspecialchars($o['name']); ?></div>
        <div class="odetail"><strong>Phone</strong><?php echo $o['number']; ?></div>
        <div class="odetail"><strong>Payment</strong><?php echo ucfirst($o['method']); ?></div>
        <div class="odetail"><strong>Order Status</strong><?php echo ucfirst($o['order_status']); ?></div>
        <div class="odetail" style="grid-column:1/-1"><strong>Delivery Address</strong><?php echo htmlspecialchars($o['address']); ?></div>
        <div class="odetail" style="grid-column:1/-1"><strong>Items Ordered</strong><?php echo htmlspecialchars($o['total_products']); ?></div>
      </div>
      <div class="order-card-foot">
        <span class="total">Total: <span>&#8377;<?php echo number_format($o['total_price'],2); ?></span></span>
        <a href="shop.php" class="option-btn" style="padding:.8rem 2rem;font-size:1.4rem"><i class="fas fa-redo"></i> Reorder</a>
      </div>
    </div>
    <?php }} else{echo '<p class="empty">No orders placed yet. <a href="shop.php" style="color:var(--amber-dark);font-weight:600">Start shopping</a></p>';} ?>
  </div>
</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body></html>