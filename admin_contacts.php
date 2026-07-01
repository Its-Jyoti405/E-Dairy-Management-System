<?php
include 'config.php'; session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){header('location:login.php');}
if(isset($_GET['delete'])){mysqli_query($conn,"DELETE FROM `message` WHERE id='".(int)$_GET['delete']."'");header('location:admin_contacts.php');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Messages — Milky Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">
  <style>
    .msg-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(36rem,1fr));gap:2rem}
    .msg-card{background:#fff;border-radius:var(--r-md);border:1px solid var(--border);box-shadow:var(--sh-sm);overflow:hidden;transition:var(--ease);display:flex;flex-direction:column}
    .msg-card:hover{transform:translateY(-3px);box-shadow:var(--sh-md)}
    .msg-card-head{background:var(--amber-dark);padding:1.8rem 2rem;display:flex;align-items:center;justify-content:space-between;gap:1rem}
    .msg-card-head .sender{display:flex;align-items:center;gap:1rem}
    .msg-card-head .avatar{width:4rem;height:4rem;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:1.7rem;font-weight:700;color:#fff;font-family:'Playfair Display',serif;flex-shrink:0}
    .msg-card-head .name{font-size:1.6rem;font-weight:600;color:#fff}
    .msg-card-head .uid{font-size:1.25rem;color:rgba(255,255,255,.6)}
    .msg-card-body{padding:2rem;flex:1;display:flex;flex-direction:column;gap:1rem}
    .msg-contact{display:flex;align-items:center;gap:.7rem;font-size:1.4rem;color:var(--muted)}
    .msg-contact i{color:var(--amber);width:1.8rem}
    .msg-text{background:var(--light-bg);border-radius:var(--r-sm);padding:1.4rem;font-size:1.5rem;color:var(--text);line-height:1.8;border-left:3px solid var(--amber-light);flex:1}
    .msg-card-foot{padding:1.4rem 2rem;border-top:1px solid var(--border);display:flex;gap:1rem;align-items:center}
  </style>
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-topbar">
  <h1><i class="fas fa-envelope"></i> Customer Messages</h1>
  <div class="topbar-actions" style="font-size:1.45rem;color:var(--muted)">
    <?php $cnt=mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `message`")); ?>
    <strong style="color:var(--dark)"><?php echo $cnt; ?></strong> message<?php echo $cnt!=1?'s':''; ?> received
  </div>
</div>
<div class="admin-content">
  <div class="msg-cards">
    <?php
    $mq=mysqli_query($conn,"SELECT * FROM `message` ORDER BY id DESC") or die('query failed');
    if(mysqli_num_rows($mq)>0){
      while($m=mysqli_fetch_assoc($mq)):
    ?>
    <div class="msg-card">
      <div class="msg-card-head">
        <div class="sender">
          <div class="avatar"><?php echo strtoupper(substr($m['name'],0,1)); ?></div>
          <div><div class="name"><?php echo htmlspecialchars($m['name']); ?></div><div class="uid">User ID #<?php echo $m['user_id']; ?></div></div>
        </div>
        <a href="admin_contacts.php?delete=<?php echo $m['id']; ?>" onclick="return confirm('Delete this message?')" style="color:rgba(255,255,255,.7);font-size:1.8rem;transition:var(--ease)" title="Delete"><i class="fas fa-times-circle"></i></a>
      </div>
      <div class="msg-card-body">
        <div class="msg-contact"><i class="fas fa-phone"></i><?php echo htmlspecialchars($m['number']); ?></div>
        <div class="msg-contact"><i class="fas fa-envelope"></i><?php echo htmlspecialchars($m['email']); ?></div>
        <div class="msg-text"><?php echo nl2br(htmlspecialchars($m['message'])); ?></div>
      </div>
      <div class="msg-card-foot">
        <a href="mailto:<?php echo urlencode($m['email']); ?>?subject=Re: Your enquiry with Milky" class="btn" style="font-size:1.35rem;padding:.9rem 1.8rem"><i class="fas fa-reply"></i> Reply</a>
        <a href="tel:<?php echo $m['number']; ?>" class="option-btn" style="font-size:1.35rem;padding:.9rem 1.8rem"><i class="fas fa-phone"></i> Call</a>
      </div>
    </div>
    <?php endwhile; }else{echo '<div class="empty" style="grid-column:1/-1">No messages received yet.</div>';} ?>
  </div>
</div>
  </main>
</div>
<script>document.querySelectorAll('.message').forEach(m=>{setTimeout(()=>{m.style.opacity='0';setTimeout(()=>m.remove(),400)},4000)});</script>
</body></html>