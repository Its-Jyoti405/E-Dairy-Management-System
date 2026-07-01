<?php
include 'config.php'; session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){header('location:login.php');}
if(isset($_POST['update_order'])){
  $oid=(int)$_POST['order_id'];$os=$_POST['update_order_status'];$ps=$_POST['update_payment_status'];
  mysqli_query($conn,"UPDATE `orders` SET order_status='$os',payment_status='$ps' WHERE id='$oid'") or die('query failed');
  $message[]='Order updated successfully!';
}
if(isset($_GET['delete'])){mysqli_query($conn,"DELETE FROM `orders` WHERE id='".(int)$_GET['delete']."'");header('location:admin_orders.php');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Orders — Milky Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-topbar">
  <h1><i class="fas fa-shopping-bag"></i> All Orders</h1>
  <div class="topbar-actions" style="display:flex;gap:1rem;align-items:center;font-size:1.45rem;color:var(--muted)">
    Total: <strong style="color:var(--dark)"><?php echo mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `orders`")); ?></strong> orders
  </div>
</div>
<div class="admin-content">
  <div class="panel">
    <div class="full-table-wrap">
      <table class="data-table">
        <thead><tr><th>Order #</th><th>Customer</th><th>Contact</th><th>Date</th><th>Items</th><th>Total</th><th>Order Status</th><th>Payment</th><th>Actions</th></tr></thead>
        <tbody>
        <?php
        $oq=mysqli_query($conn,"SELECT * FROM `orders` ORDER BY id DESC") or die('query failed');
        if(mysqli_num_rows($oq)>0){
          while($o=mysqli_fetch_assoc($oq)){
            if($o['order_status'] == 'completed'){ $oc = 'pill-complete'; }
            elseif($o['order_status'] == 'placed'){ $oc = 'pill-placed'; }
            else { $oc = 'pill-pending'; }
            $pc=($o['payment_status']=='completed')?'pill-complete':'pill-pending';
        ?>
          <tr>
            <td><strong>#<?php echo str_pad($o['id'],5,'0',STR_PAD_LEFT); ?></strong></td>
            <td><?php echo htmlspecialchars($o['name']); ?><br><small style="color:var(--muted)"><?php echo htmlspecialchars($o['email']); ?></small></td>
            <td><?php echo $o['number']; ?></td>
            <td style="white-space:nowrap"><?php echo $o['placed_on']; ?></td>
            <td style="max-width:18rem;font-size:1.35rem"><?php echo htmlspecialchars($o['total_products']); ?></td>
            <td style="font-weight:700;color:var(--amber-dark);white-space:nowrap">&#8377;<?php echo number_format($o['total_price'],2); ?></td>
            <td><span class="pill <?php echo $oc; ?>"><?php echo ucfirst($o['order_status']); ?></span></td>
            <td><span class="pill <?php echo $pc; ?>"><?php echo ucfirst($o['payment_status']); ?></span></td>
            <td>
              <form action="" method="post" style="display:flex;flex-direction:column;gap:.6rem;min-width:17rem">
                <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                <select name="update_order_status" class="field-inline">
                  <option value="pending"   <?php if($o['order_status']=='pending')  echo 'selected'; ?>>Pending</option>
                  <option value="placed"    <?php if($o['order_status']=='placed')   echo 'selected'; ?>>Placed</option>
                  <option value="completed" <?php if($o['order_status']=='completed')echo 'selected'; ?>>Completed</option>
                </select>
                <select name="update_payment_status" class="field-inline">
                  <option value="pending"   <?php if($o['payment_status']=='pending')  echo 'selected'; ?>>Pending</option>
                  <option value="completed" <?php if($o['payment_status']=='completed')echo 'selected'; ?>>Completed</option>
                </select>
                <div style="display:flex;gap:.6rem">
                  <button type="submit" name="update_order" class="option-btn" style="flex:1;padding:.8rem;font-size:1.3rem"><i class="fas fa-save"></i> Save</button>
                  <a href="admin_orders.php?delete=<?php echo $o['id']; ?>" class="delete-btn" style="padding:.8rem 1rem;font-size:1.3rem" onclick="return confirm('Delete this order?')"><i class="fas fa-trash"></i></a>
                </div>
              </form>
            </td>
          </tr>
        <?php }}else{echo '<tr><td colspan="9" style="text-align:center;padding:4rem;color:var(--muted);font-size:1.6rem">No orders yet.</td></tr>';} ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
  </main>
</div>
<script>document.querySelectorAll('.message').forEach(m=>{setTimeout(()=>{m.style.opacity='0';setTimeout(()=>m.remove(),400)},4000)});</script>
</body></html>