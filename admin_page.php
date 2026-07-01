<?php
include 'config.php'; session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){header('location:login.php');}
// stats
$pending_orders    =mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `orders` WHERE order_status='pending'"));
$completed_orders  =mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `orders` WHERE order_status='completed'"));
$pending_payments  =mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `orders` WHERE payment_status='pending'"));
$completed_payments=mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `orders` WHERE payment_status='completed'"));
$total_products    =mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `products`"));
$total_users       =mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `users` WHERE user_type='user'"));
$total_msgs        =mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `message`"));
$rev_r=mysqli_query($conn,"SELECT SUM(total_price) AS rev FROM `orders` WHERE payment_status='completed'");
$revenue=mysqli_fetch_assoc($rev_r)['rev']??0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Dashboard — Milky Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-topbar">
  <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
  <div class="topbar-actions">
    <span style="font-size:1.4rem;color:var(--muted)"><i class="fas fa-calendar-alt" style="margin-right:.4rem"></i><?php echo date('d M Y'); ?></span>
    <a href="admin_products.php" class="btn"><i class="fas fa-plus"></i> Add Product</a>
  </div>
</div>
<div class="admin-content">

  <!-- STAT CARDS -->
  <div class="stat-cards">
    <div class="stat-card amber">
      <div class="stat-icon"><i class="fas fa-indian-rupee-sign"></i></div>
      <div><div class="stat-num">&#8377;<?php echo number_format($revenue,0); ?></div><div class="stat-label">Total Revenue</div><div class="stat-change up"><i class="fas fa-arrow-up"></i> Collected Payments</div></div>
    </div>
    <div class="stat-card sky">
      <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
      <div><div class="stat-num"><?php echo $pending_orders; ?></div><div class="stat-label">Pending Orders</div><div class="stat-change down"><i class="fas fa-clock"></i> Awaiting Processing</div></div>
    </div>
    <div class="stat-card green">
      <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
      <div><div class="stat-num"><?php echo $completed_orders; ?></div><div class="stat-label">Completed Orders</div><div class="stat-change up"><i class="fas fa-arrow-up"></i> Fulfilled</div></div>
    </div>
    <div class="stat-card red">
      <div class="stat-icon"><i class="fas fa-credit-card"></i></div>
      <div><div class="stat-num"><?php echo $pending_payments; ?></div><div class="stat-label">Pending Payments</div><div class="stat-change down"><i class="fas fa-exclamation-triangle"></i> Need Collection</div></div>
    </div>
    <div class="stat-card amber">
      <div class="stat-icon"><i class="fas fa-boxes"></i></div>
      <div><div class="stat-num"><?php echo $total_products; ?></div><div class="stat-label">Products Listed</div><div class="stat-change up"><i class="fas fa-store"></i> Active Catalogue</div></div>
    </div>
    <div class="stat-card green">
      <div class="stat-icon"><i class="fas fa-users"></i></div>
      <div><div class="stat-num"><?php echo $total_users; ?></div><div class="stat-label">Registered Users</div><div class="stat-change up"><i class="fas fa-user-plus"></i> Growing Base</div></div>
    </div>
    <div class="stat-card sky">
      <div class="stat-icon"><i class="fas fa-wallet"></i></div>
      <div><div class="stat-num"><?php echo $completed_payments; ?></div><div class="stat-label">Paid Orders</div><div class="stat-change up"><i class="fas fa-arrow-up"></i> Cleared</div></div>
    </div>
    <div class="stat-card purple">
      <div class="stat-icon"><i class="fas fa-envelope"></i></div>
      <div><div class="stat-num"><?php echo $total_msgs; ?></div><div class="stat-label">New Messages</div><div class="stat-change down"><i class="fas fa-bell"></i> Needs Response</div></div>
    </div>
  </div>

  <!-- PANELS -->
  <div class="dash-panels">
    <!-- Recent Orders -->
    <div class="panel">
      <div class="panel-head">
        <h2><i class="fas fa-shopping-bag"></i> Recent Orders</h2>
        <a href="admin_orders.php"><i class="fas fa-arrow-right"></i> View All</a>
      </div>
      <div class="full-table-wrap">
        <table class="data-table">
          <thead><tr><th>Order #</th><th>Customer</th><th>Date</th><th>Amount</th><th>Order Status</th><th>Payment</th></tr></thead>
          <tbody>
          <?php
          $recent=mysqli_query($conn,"SELECT * FROM `orders` ORDER BY id DESC LIMIT 8") or die('query failed');
          if(mysqli_num_rows($recent)>0){
            while($r=mysqli_fetch_assoc($recent)){
              if($r['order_status'] == 'completed'){ $oc = 'pill-complete'; }
              elseif($r['order_status'] == 'placed'){ $oc = 'pill-placed'; }
              else { $oc = 'pill-pending'; }
              $pc=($r['payment_status']=='completed')?'pill-complete':'pill-pending';
            ?>
            <tr>
              <td><strong>#<?php echo str_pad($r['id'],5,'0',STR_PAD_LEFT); ?></strong></td>
              <td><?php echo htmlspecialchars($r['name']); ?></td>
              <td><?php echo $r['placed_on']; ?></td>
              <td style="font-weight:700;color:var(--amber-dark)">&#8377;<?php echo number_format($r['total_price'],2); ?></td>
              <td><span class="pill <?php echo $oc; ?>"><?php echo ucfirst($r['order_status']); ?></span></td>
              <td><span class="pill <?php echo $pc; ?>"><?php echo ucfirst($r['payment_status']); ?></span></td>
            </tr>
          <?php }}else{echo '<tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--muted)">No orders yet.</td></tr>';} ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Recent Messages -->
    <div class="panel">
      <div class="panel-head">
        <h2><i class="fas fa-envelope"></i> Recent Messages</h2>
        <a href="admin_contacts.php"><i class="fas fa-arrow-right"></i> View All</a>
      </div>
      <?php
      $msgs=mysqli_query($conn,"SELECT * FROM `message` ORDER BY id DESC LIMIT 6") or die('query failed');
      if(mysqli_num_rows($msgs)>0){
        while($m=mysqli_fetch_assoc($msgs)){
      ?>
      <div class="msg-item">
        <div class="msg-avatar"><?php echo strtoupper(substr($m['name'],0,1)); ?></div>
        <div>
          <div class="msg-name"><?php echo htmlspecialchars($m['name']); ?></div>
          <div class="msg-preview"><?php echo htmlspecialchars($m['message']); ?></div>
        </div>
      </div>
      <?php }}else{echo '<p style="text-align:center;padding:3rem;color:var(--muted);font-size:1.5rem">No messages yet.</p>';} ?>
    </div>
  </div>

  <!-- Quick Actions -->
  <div style="background:#fff;border-radius:var(--r-md);padding:2.5rem;border:1px solid var(--border);box-shadow:var(--sh-sm)">
    <h2 style="font-family:'Playfair Display',serif;font-size:2rem;color:var(--dark);margin-bottom:2rem;display:flex;align-items:center;gap:.8rem"><i class="fas fa-bolt" style="color:var(--amber)"></i> Quick Actions</h2>
    <div style="display:flex;flex-wrap:wrap;gap:1.2rem">
      <a href="admin_products.php" class="btn"><i class="fas fa-plus-circle"></i> Add New Product</a>
      <a href="admin_orders.php" class="option-btn"><i class="fas fa-boxes"></i> Manage Orders</a>
      <a href="admin_users.php" class="sky-btn"><i class="fas fa-users"></i> View Customers</a>
      <a href="admin_contacts.php" class="btn" style="background:var(--amber-dark)"><i class="fas fa-reply"></i> Reply Messages</a>
    </div>
  </div>
</div>
  </main>
</div>
<script>
document.querySelectorAll('.message').forEach(m=>{setTimeout(()=>{m.style.opacity='0';setTimeout(()=>m.remove(),400)},4000)});
</script>
</body></html>
