<?php
include 'config.php'; session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){header('location:login.php');}
if(isset($_POST['order_btn'])){
  $name=mysqli_real_escape_string($conn,$_POST['name']);
  $number=$_POST['number'];
  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $method=mysqli_real_escape_string($conn,$_POST['method']);
  $address=mysqli_real_escape_string($conn,'Flat '.$_POST['flat'].', '.$_POST['street'].', '.$_POST['city'].', '.$_POST['state'].', '.$_POST['country'].' - '.$_POST['pin_code']);
  $placed_on=date('d-M-Y');
  $cart_total=0;$cart_products=[''];
  $cq=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
  if(mysqli_num_rows($cq)>0){
    while($ci=mysqli_fetch_assoc($cq)){
      $ml = (int)($ci['milk_quantity'] ?? 1000);
      if ($ml == 0) $ml = 1000;
      
      // Build product string for DB (e.g. Milk (500 size x 2))
      $cart_products[] = $ci['name'].' (size:'.$ml.' x'.$ci['quantity'].')';
      
      $price_per_item = $ci['price'] * ($ml / 1000);
      $s = $ci['quantity'] * $price_per_item;
      $cart_total += $s;
    }
  }
  $tp=implode(', ',$cart_products);
  if($cart_total==0){$message[]='Your cart is empty!';}
  else{
    $oc=mysqli_query($conn,"SELECT * FROM `orders` WHERE user_id='$user_id' AND name='$name' AND number='$number' AND total_products='$tp' AND total_price='$cart_total'") or die('query failed');
    if(mysqli_num_rows($oc)>0){$message[]='This order has already been placed!';}
    else{
      mysqli_query($conn,"INSERT INTO `orders`(user_id,name,number,email,method,address,total_products,total_price,placed_on) VALUES('$user_id','$name','$number','$email','$method','$address','$tp','$cart_total','$placed_on')") or die('query failed');
      mysqli_query($conn,"DELETE FROM `cart` WHERE user_id='$user_id'") or die('query failed');
      $message[]='Order placed successfully! Thank you for choosing Milky.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Checkout — Milky</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="heading"><h3>Checkout</h3><p><a href="home.php">Home</a> / <a href="cart.php">Cart</a> / Checkout</p></div>
<section class="display-order">
  <div class="inner reveal">
    <h2><i class="fas fa-clipboard-list" style="color:var(--amber);margin-right:.8rem"></i> Order Summary</h2>
    <?php
    $grand=0;
    $cq=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
    if(mysqli_num_rows($cq)>0){
      while($c=mysqli_fetch_assoc($cq)){
        $ml = (int)($c['milk_quantity'] ?? 1000);
        if ($ml == 0) $ml = 1000;
        
        $price_per_item = $c['price'] * ($ml / 1000);
        $tp = $c['quantity'] * $price_per_item;
        $grand += $tp;
        
        $size_label = ($ml == 1000) ? 'Full Size' : $ml;
        echo '<div class="product-row">'.htmlspecialchars($c['name']).' <small>('.$size_label.')</small> &times; '.$c['quantity'].'<span>&#8377;'.number_format($tp,2).'</span></div>';
      }
    }else{echo '<p class="empty">Cart is empty.</p>';}
    ?>
    <div class="grand-total">Total: <span>&#8377;<?php echo number_format($grand,2); ?></span></div>
  </div>
</section>
<section class="checkout">
  <form action="" method="post">
    <h3>Delivery &amp; Payment Details</h3>
    <div class="checkout-grid">
      <div class="co-field"><label><i class="fas fa-user"></i> Full Name</label><input type="text" name="name" required placeholder="Your full name"></div>
      <div class="co-field"><label><i class="fas fa-phone"></i> Phone Number</label><input type="number" name="number" required placeholder="10-digit mobile number"></div>
      <div class="co-field"><label><i class="fas fa-envelope"></i> Email Address</label><input type="email" name="email" required placeholder="you@email.com"></div>
      <div class="co-field"><label><i class="fas fa-credit-card"></i> Payment Method</label>
        <select name="method" id="payment_method" onchange="toggleUPI()">
          <option value="cash on delivery">Cash on Delivery</option>
          <option value="upi">UPI / PhonePe / GPay</option>
          <option value="credit card">Credit / Debit Card</option>
          <option value="paytm">Paytm</option>
          <option value="net banking">Net Banking</option>
        </select>
      </div>
      
      <!-- UPI QR Box (Hidden by default) -->
      <div id="upi_box" style="display:none; grid-column:1/-1; background:var(--green-pale); padding:2.5rem; border-radius:var(--r-md); text-align:center; border:2px dashed var(--green); margin-bottom:1rem; animation: slideDown 0.3s ease;">
         <h4 style="font-size:1.8rem; color:var(--dark); margin-bottom:1rem;"><i class="fas fa-qrcode" style="color:var(--green)"></i> Scan to Pay via PhonePe / UPI</h4>
         <p style="font-size:1.5rem; margin-bottom: 1.5rem;">Amount to Pay: <strong style="color:var(--green); font-size:2rem;">&#8377;<?php echo number_format($grand ?? 0, 2); ?></strong></p>
         <div style="background:#111; max-width:280px; margin:0 auto; padding: 1rem; border-radius:var(--r-md); box-shadow:var(--sh-md); border:1px solid var(--border);">
            <img src="images/upi_qr1.jpeg" alt="UPI QR Code" style="width:100%; height:auto; border-radius:var(--r-sm); display:block;">
         </div>
         <p style="margin-top: 1.5rem; font-size:1.5rem; color:var(--text); font-weight:600;">Account: <span style="letter-spacing:1px; color:var(--green-dark);">Mrs JYOTI SHIVAJI GAVALI1</span></p>
         <p style="margin-top: .8rem; font-size:1.3rem; color:var(--muted);"><i class="fas fa-info-circle"></i> Once payment is successful, click "Place Order" below.</p>
      </div>
      <div class="co-field"><label><i class="fas fa-home"></i> Flat / House No.</label><input type="text" name="flat" required placeholder="e.g. Flat 42B"></div>
      <div class="co-field"><label><i class="fas fa-road"></i> Street / Area</label><input type="text" name="street" required placeholder="e.g. MG Road, Andheri"></div>
      <div class="co-field"><label><i class="fas fa-city"></i> City</label><input type="text" name="city" required placeholder="e.g. Mumbai"></div>
      <div class="co-field"><label><i class="fas fa-map"></i> State</label><input type="text" name="state" required placeholder="e.g. Maharashtra"></div>
      <div class="co-field"><label><i class="fas fa-globe-asia"></i> Country</label><input type="text" name="country" required placeholder="e.g. India"></div>
      <div class="co-field"><label><i class="fas fa-map-pin"></i> PIN Code</label><input type="number" name="pin_code" required placeholder="6-digit PIN code"></div>
    </div>
    <div style="text-align:center;margin-top:1.5rem"><input type="submit" name="order_btn" value="Place Order" class="btn" style="min-width:22rem;font-size:1.8rem;padding:1.4rem 3rem"></div>
  </form>
</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
<script>
  function toggleUPI() {
    var method = document.getElementById('payment_method').value;
    var upiBox = document.getElementById('upi_box');
    if(method === 'upi') {
      upiBox.style.display = 'block';
    } else {
      upiBox.style.display = 'none';
    }
  }
</script>
</body></html>