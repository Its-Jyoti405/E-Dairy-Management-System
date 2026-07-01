<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
  header('location:login.php');
}
if (isset($_POST['send'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $number = $_POST['number'];
  $msg = mysqli_real_escape_string($conn, $_POST['message']);
  $chk = mysqli_query($conn, "SELECT * FROM `message` WHERE name='$name' AND email='$email' AND number='$number' AND message='$msg'") or die('query failed');
  if (mysqli_num_rows($chk) > 0) {
    $message[] = 'You have already sent this message!';
  }
  else {
    mysqli_query($conn, "INSERT INTO `message`(user_id,name,email,number,message) VALUES('$user_id','$name','$email','$number','$msg')") or die('query failed');
    $message[] = 'Message sent! We will respond within 24 hours.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="description" content="Contact Milky — reach our dairy team for any queries.">
  <title>Contact Us — Milky</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="heading"><h3>Contact Us</h3><p><a href="home.php">Home</a> / Contact</p></div>
<section class="contact">
  <div class="container">
    <div class="contact-info-panel reveal">
      <h3>Get In Touch</h3>
      <p class="intro">Have questions about products, delivery or billing? We would love to hear from you. Our team responds within 24 hours.</p>
      <div class="info-row"><div class="info-icon"><i class="fas fa-map-marker-alt"></i></div><div class="info-text"><h4>Our Location</h4><p>Nashik, Maharashtra<br>India &ndash; 422001</p></div></div>
      <div class="info-row"><div class="info-icon"><i class="fas fa-phone"></i></div><div class="info-text"><h4>Phone Numbers</h4><p>+91 9146347024<br>+91 9146347024</p></div></div>
      <div class="info-row"><div class="info-icon"><i class="fas fa-envelope"></i></div><div class="info-text"><h4>Email Address</h4><p>gavalijyoti455@gmail.com<br>support@milky.farm</p></div></div>
      <div class="info-row"><div class="info-icon"><i class="fas fa-clock"></i></div><div class="info-text"><h4>Working Hours</h4><p>Monday &ndash; Saturday<br>6:00 AM &ndash; 8:00 PM</p></div></div>
    </div>
    <div class="contact-form-wrap reveal">
      <h3>Send a Message</h3>
      <p class="sub">Fill the form below and we will get back to you as soon as possible.</p>
      <form action="" method="post">
        <input type="text" name="name" class="field-box" placeholder="Your full name" required>
        <input type="email" name="email" class="field-box" placeholder="Your email address" required>
        <input type="number" name="number" class="field-box" placeholder="Your phone number" required>
        <textarea name="message" class="field-box" placeholder="Tell us how we can help you..." required></textarea>
        <input type="submit" name="send" value="Send Message" class="btn" style="width:100%">
      </form>
    </div>
  </div>
</section>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body></html>