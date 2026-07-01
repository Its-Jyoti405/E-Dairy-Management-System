<?php
include 'config.php'; session_start();
if(isset($_POST['submit'])){
  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $pass=mysqli_real_escape_string($conn,md5($_POST['password']));
  $sel=mysqli_query($conn,"SELECT * FROM `users` WHERE email='$email' AND password='$pass'") or die('query failed');
  if(mysqli_num_rows($sel)>0){
    $row=mysqli_fetch_assoc($sel);
    if($row['user_type']=='admin'){
      $_SESSION['admin_name']=$row['name'];$_SESSION['admin_email']=$row['email'];$_SESSION['admin_id']=$row['id'];
      header('location:admin_page.php');
    }elseif($row['user_type']=='user'){
      $_SESSION['user_name']=$row['name'];$_SESSION['user_email']=$row['email'];$_SESSION['user_id']=$row['id'];
      header('location:home.php');
    }
  }else{$message[]='Incorrect email or password. Please try again.';}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="description" content="Sign in to your Milky account.">
  <title>Login — Milky</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php if(isset($message)){foreach($message as $m){echo '<div class="message"><span><i class="fas fa-exclamation-circle"></i> '.htmlspecialchars($m).'</span><i class="fas fa-times" onclick="this.parentElement.remove()"></i></div>';}} ?>
<div class="form-page">
  <div class="form-visual">
    <div class="visual-inner">
      <div class="vis-icon"><i class="fas fa-cow"></i></div>
      <h2>Welcome Back<br>to Milky</h2>
      <p>Your farm-fresh dairy delivered every morning. Sign in to manage your orders and preferences.</p>
      <div class="vis-badges">
        <span class="vis-badge"><i class="fas fa-leaf"></i> 100% Natural</span>
        <span class="vis-badge"><i class="fas fa-truck"></i> Daily Delivery</span>
        <span class="vis-badge"><i class="fas fa-shield-alt"></i> Verified Quality</span>
        <span class="vis-badge"><i class="fas fa-file-invoice"></i> Easy Billing</span>
      </div>
    </div>
  </div>
  <div class="form-side">
    <div class="auth-wrap">
      <div class="auth-brand"><i class="fas fa-cow"></i> Milk<span>y</span></div>
      <div class="auth-card">
        <h3>Sign In</h3>
        <p class="sub">Welcome back! Enter your credentials to continue.</p>
        <form action="" method="post">
          <div class="auth-field">
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" id="email" name="email" class="auth-input" placeholder="you@email.com" required>
          </div>
          <div class="auth-field">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <div class="pw-wrap">
              <input type="password" id="password" name="password" class="auth-input" placeholder="Enter your password" required>
              <i class="fas fa-eye pw-toggle" id="pwToggle" onclick="togglePw()"></i>
            </div>
          </div>
          <input type="submit" name="submit" value="Login to Account" class="btn">
        </form>
        <p class="auth-footer">Don't have an account? <a href="register.php">Create one free</a></p>
      </div>
    </div>
  </div>
</div>
<script>
function togglePw(){
  const p=document.getElementById('password'),i=document.getElementById('pwToggle');
  p.type=p.type==='password'?'text':'password';
  i.classList.toggle('fa-eye');i.classList.toggle('fa-eye-slash');
}
</script>
</body></html>