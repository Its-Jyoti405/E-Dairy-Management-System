<?php
if(isset($message)){foreach($message as $msg){echo '<div class="message"><span><i class="fas fa-check-circle"></i> '.htmlspecialchars($msg).'</span><i class="fas fa-times" onclick="this.parentElement.remove()"></i></div>';}}
$current=basename($_SERVER['PHP_SELF']);
function nav($file,$icon,$label,$cur){
  $a=($cur==$file)?'active':'';
  echo '<a href="'.$file.'" class="'.$a.'"><i class="fas fa-'.$icon.'"></i> '.$label.'</a>';
}
?>
<div class="admin-header">
  <div class="header-inner">
    <a href="admin_page.php" class="logo"><i class="fas fa-cow"></i> Milk<span>y</span></a>
  </div>
</div>
<div class="admin-layout">
  <aside class="admin-sidebar">
    <div class="sb-brand">
      <div class="brand-icon"><i class="fas fa-tachometer-alt"></i></div>
      <span>Admin <em>Panel</em></span>
    </div>
    <nav class="sb-nav">
      <div class="sb-section">Overview</div>
      <?php nav('admin_page.php','tachometer-alt','Dashboard',$current); ?>
      <div class="sb-section">Catalogue</div>
      <?php nav('admin_products.php','boxes','Products',$current); ?>
      <div class="sb-section">Operations</div>
      <?php nav('admin_orders.php','shopping-bag','Orders',$current); ?>
      <?php nav('admin_users.php','users','Customers',$current); ?>
      <?php nav('admin_contacts.php','envelope','Messages',$current); ?>
      <div class="sb-section">Site</div>
      <a href="home.php" target="_blank"><i class="fas fa-external-link-alt"></i> View Store</a>
    </nav>
    <div class="sb-user">
      <div class="user-info">
        <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin_name'],0,1)); ?></div>
        <div><p><?php echo htmlspecialchars($_SESSION['admin_name']); ?></p><small><?php echo htmlspecialchars($_SESSION['admin_email']); ?></small></div>
      </div>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </aside>
  <main class="admin-main">