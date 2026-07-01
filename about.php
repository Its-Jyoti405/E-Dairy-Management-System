<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
  header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="description" content="Learn about Milky — our story, mission, values and the team behind your daily dairy.">
  <title>About Us — Milky</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="heading"><h3>About Milky</h3><p><a href="home.php">Home</a> / About</p></div>

<!-- MISSION -->
<section class="about">
  <div class="flex">
    <div class="img-side"><img src="images/about-img.png" alt="Fresh dairy farm"></div>
    <div class="content reveal">
      <div class="pre-label"><i class="fas fa-seedling"></i> Our Story</div>
      <h3>From Our Farm<br>to Your Table</h3>
      <p>Founded in 2018, Milky began with a simple belief — every family deserves access to pure, unadulterated dairy. We partner directly with verified local farmers, eliminating middlemen to deliver the freshest milk and dairy products at honest prices.</p>
      <p style="margin-top:1rem">Our entire supply chain is transparent. From early morning milking to refrigerated delivery, we track every step to ensure you receive nature's best — untouched.</p>
      <a href="shop.php" class="white-btn" style="margin-top:1.5rem"><i class="fas fa-store"></i> Explore Products</a>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="about-stats">
  <h2 class="section-title reveal">Milky by the Numbers</h2>
  <p class="section-sub reveal">A decade of growing trust, one litre at a time.</p>
  <div class="container">
    <div class="astat reveal">
      <div class="astat-icon"><i class="fas fa-users"></i></div>
      <div class="astat-num">10,000+</div>
      <p>Happy Families</p>
    </div>
    <div class="astat reveal">
      <div class="astat-icon"><i class="fas fa-tractor"></i></div>
      <div class="astat-num">500+</div>
      <p>Farming Partners</p>
    </div>
    <div class="astat reveal">
      <div class="astat-icon"><i class="fas fa-calendar-alt"></i></div>
      <div class="astat-num">6+</div>
      <p>Years of Service</p>
    </div>
    <div class="astat reveal">
      <div class="astat-icon"><i class="fas fa-shield-alt"></i></div>
      <div class="astat-num">100%</div>
      <p>Quality Certified</p>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section class="why-us">
  <h2 class="section-title reveal">Why Choose Milky?</h2>
  <p class="section-sub reveal">Six reasons thousands of families trust us for their daily dairy needs.</p>
  <div class="cards">
    <div class="why-card reveal">
      <div class="icon"><i class="fas fa-leaf"></i></div>
      <h4>No Preservatives</h4>
      <p>All products are 100% natural with zero artificial additives or preservatives. Pure as it comes.</p>
    </div>
    <div class="why-card reveal">
      <div class="icon"><i class="fas fa-truck"></i></div>
      <h4>Daily Morning Delivery</h4>
      <p>Collected at dawn, delivered by morning. Our logistics are built for speed and food safety.</p>
    </div>
    <div class="why-card reveal">
      <div class="icon"><i class="fas fa-award"></i></div>
      <h4>Quality Certified</h4>
      <p>All our dairy passes FSSAI-compliant quality checks at every stage of the supply chain.</p>
    </div>
    <div class="why-card reveal">
      <div class="icon"><i class="fas fa-handshake"></i></div>
      <h4>Farmer-First Model</h4>
      <p>We pay our farmers fairly. No middlemen — your money goes directly to the people who work hardest.</p>
    </div>
    <div class="why-card reveal">
      <div class="icon"><i class="fas fa-file-invoice"></i></div>
      <h4>Transparent Billing</h4>
      <p>Clear, itemised receipts for every order. No hidden charges. Your trust is our foundation.</p>
    </div>
    <div class="why-card reveal">
      <div class="icon"><i class="fas fa-headset"></i></div>
      <h4>Responsive Support</h4>
      <p>Our customer care team is reachable Mon–Sat. Questions or concerns — we respond within hours.</p>
    </div>
  </div>
</section>

<!-- TEAM -->
<section class="team-section">
  <h2 class="section-title reveal">Meet the Team</h2>
  <p class="section-sub reveal">The passionate people working every day to bring fresh dairy to your home.</p>
  <div class="team-cards">
    <div class="team-card reveal">
      <div class="avatar-area"><i class="fas fa-user-tie"></i></div>
      <div class="card-info">
        <h4>Jyoti Gavali</h4>
        <p>Founder &amp; CEO</p>
        <div class="socials">
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
        </div>
      </div>
    </div>
    <div class="team-card reveal">
      <div class="avatar-area"><i class="fas fa-flask"></i></div>
      <div class="card-info">
        <h4>Dr. Shrijita Kulkarni</h4>
        <p>Head of Quality &amp; Safety</p>
        <div class="socials">
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
        </div>
      </div>
    </div>
    <div class="team-card reveal">
      <div class="avatar-area"><i class="fas fa-boxes"></i></div>
      <div class="card-info">
        <h4>Arjun Tiwari</h4>
        <p>Logistics &amp; Delivery Head</p>
        <div class="socials">
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </div>
    <div class="team-card reveal">
      <div class="avatar-area"><i class="fas fa-tractor"></i></div>
      <div class="card-info">
        <h4>Kavya Jaju</h4>
        <p>Farmer Relations Manager</p>
        <div class="socials">
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="home-contact">
  <div class="content">
    <h3>Ready to Experience Pure Dairy?</h3>
    <p>Join thousands of families who woke up to fresh, farm-pure dairy delivered every morning.</p>
    <div style="display:flex;gap:1.5rem;justify-content:center;flex-wrap:wrap">
      <a href="shop.php" class="white-btn"><i class="fas fa-store"></i> Shop Now</a>
      <a href="contact.php" class="btn"><i class="fas fa-paper-plane"></i> Talk to Us</a>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body></html>