<?php
include 'config.php';
if(isset($_POST['submit'])){
  $name=mysqli_real_escape_string($conn,$_POST['name']);
  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $pass=mysqli_real_escape_string($conn,md5($_POST['password']));
  $cpass=mysqli_real_escape_string($conn,md5($_POST['cpassword']));
  $utype=$_POST['user_type'];
  $chk=mysqli_query($conn,"SELECT * FROM `users` WHERE email='$email'") or die('query failed');
  if(mysqli_num_rows($chk)>0){$message[]='An account with this email already exists.';}
  else{
    if($pass!=$cpass){$message[]='Passwords do not match. Please try again.';}
    else{mysqli_query($conn,"INSERT INTO `users`(name,email,password,user_type) VALUES('$name','$email','$cpass','$utype')") or die('query failed');header('location:login.php');}
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="description" content="Create your Milky account and enjoy farm-fresh dairy.">
  <title>Register — Milky</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php if(isset($message)){foreach($message as $m){echo '<div class="message"><span><i class="fas fa-exclamation-circle"></i> '.htmlspecialchars($m).'</span><i class="fas fa-times" onclick="this.parentElement.remove()"></i></div>';}} ?>
<div class="form-page">
  <div class="form-visual">
    <div class="visual-inner">
      <div class="vis-icon"><i class="fas fa-seedling"></i></div>
      <h2>Join the<br>Milky Family</h2>
      <p>Get pure farm-to-table dairy at your doorstep. Register and enjoy your first delivery today.</p>
      <div class="vis-badges">
        <span class="vis-badge"><i class="fas fa-gift"></i> Free First Delivery</span>
        <span class="vis-badge"><i class="fas fa-map-marker-alt"></i> Live Order Tracking</span>
        <span class="vis-badge"><i class="fas fa-sync-alt"></i> Easy Subscriptions</span>
        <span class="vis-badge"><i class="fas fa-award"></i> Quality Guaranteed</span>
      </div>
    </div>
  </div>
  <div class="form-side">
    <div class="auth-wrap">
      <div class="auth-brand"><i class="fas fa-cow"></i> Milk<span>y</span></div>
      <div class="auth-card">
        <h3>Create Account</h3>
        <p class="sub">Start your fresh dairy journey. It only takes a minute.</p>
        <form action="" method="post">
          <div class="auth-field">
            <label for="name"><i class="fas fa-user"></i> Full Name</label>
            <input type="text" id="name" name="name" class="auth-input" placeholder="Your full name" required>
          </div>
          <div class="auth-field">
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" id="email" name="email" class="auth-input" placeholder="you@email.com" required>
          </div>
          <div class="auth-field">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" class="auth-input" placeholder="Create a strong password" required>
          </div>
          <div class="auth-field">
            <label for="cpassword"><i class="fas fa-lock"></i> Confirm Password</label>
            <input type="password" id="cpassword" name="cpassword" class="auth-input" placeholder="Repeat your password" required>
          </div>
          <div class="auth-field">
            <label for="user_type"><i class="fas fa-id-badge"></i> Account Type</label>
            <select name="user_type" id="user_type" class="auth-input" style="cursor:pointer">
              <option value="user">Customer</option>
              <option value="admin">Administrator</option>
            </select>
          </div>
          <input type="submit" name="submit" value="Create My Account" class="btn">
        </form>
        <p class="auth-footer">Already have an account? <a href="login.php">Sign in</a></p>
      </div>
    </div>
  </div>
</div>
</body></html>