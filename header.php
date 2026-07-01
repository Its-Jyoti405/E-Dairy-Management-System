<?php
if (isset($message)) {
  foreach ($message as $msg) {
    echo '<div class="message"><span><i class="fas fa-check-circle"></i> ' . htmlspecialchars($msg) . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
  }
}
?>
<header class="header">
  <div class="header-1">
    <div class="flex">
      <div class="share">
        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      </div>
      <p><i class="fas fa-truck" style="margin-right:.5rem;color:var(--amber-pale)"></i> Free delivery on orders above ₹1000 &nbsp;|&nbsp; <a href="login.php">Login</a> &nbsp;&middot;&nbsp; <a href="register.php">Register</a></p>
    </div>
  </div>
  <div class="header-2">
    <div class="flex">
      <a href="home.php" class="logo">
        <i class="fas fa-cow"></i> Milk<span>y</span>
      </a>
      <nav class="navbar" id="navbar">
        <a href="home.php"><i class="fas fa-home"></i> Home</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
        <a href="shop.php"><i class="fas fa-store"></i> Shop</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
        <a href="orders.php"><i class="fas fa-box"></i> Orders</a>
      </nav>
      <div class="icons">
        <div id="menu-btn" class="fas fa-bars" onclick="toggleMenu()" style="display:none;cursor:pointer;padding:.8rem;border-radius:.5rem;"></div>
        <a href="search_page.php" title="Search"><i class="fas fa-search"></i></a>
        <div id="user-btn" class="fas fa-user-circle" onclick="toggleUser()" title="Account"></div>
        <?php
$q = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
$n = mysqli_num_rows($q);
?>
        <a href="cart.php" title="Cart">
          <i class="fas fa-shopping-basket"></i>
          <span class="cart-count"><?php echo $n; ?></span>
        </a>
      </div>
      <div class="user-box" id="user-box">
        <div class="avatar"><i class="fas fa-user"></i></div>
        <p>Signed in as<strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
        <p>Email<strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong></p>
        <a href="logout.php" class="delete-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
    </div>
  </div>
</header>