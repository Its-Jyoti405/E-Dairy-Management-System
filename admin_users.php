<?php
include 'config.php'; session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){header('location:login.php');}
if(isset($_GET['delete'])){mysqli_query($conn,"DELETE FROM `users` WHERE id='".(int)$_GET['delete']."'");header('location:admin_users.php');}
$sql="SELECT u.id,u.name,u.email,u.user_type,COUNT(o.id) AS total_orders,IFNULL(SUM(CASE WHEN o.payment_status='pending' THEN o.total_price ELSE 0 END),0) AS pending_pay,IFNULL(SUM(CASE WHEN o.payment_status='completed' THEN o.total_price ELSE 0 END),0) AS completed_pay FROM `users` AS u LEFT JOIN `orders` AS o ON u.id=o.user_id WHERE u.user_type!='admin' GROUP BY u.id,u.name,u.email,u.user_type";
$su=mysqli_query($conn,$sql) or die('Query failed: '.mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Customers — Milky Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-topbar">
  <h1><i class="fas fa-users"></i> Customers</h1>
  <div class="topbar-actions">
    <input type="text" id="userSearch" placeholder="Search customers..." oninput="filterUsers(this.value)"
      style="padding:1rem 1.5rem;border:1.5px solid var(--border-md);border-radius:var(--r-sm);font-size:1.45rem;color:var(--text);background:var(--light-bg);min-width:24rem">
  </div>
</div>
<div class="admin-content">
  <div class="panel">
    <div class="full-table-wrap">
      <table class="data-table" id="usersTable">
        <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Type</th><th>Orders</th><th>Pending (&#8377;)</th><th>Paid (&#8377;)</th><th>Action</th></tr></thead>
        <tbody>
        <?php
        if(mysqli_num_rows($su)>0){
          while($u=mysqli_fetch_assoc($su)){
        ?>
          <tr>
            <td><?php echo $u['id']; ?></td>
            <td><strong><?php echo htmlspecialchars($u['name']); ?></strong></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td><span class="pill pill-user"><i class="fas fa-user"></i> <?php echo ucfirst($u['user_type']); ?></span></td>
            <td style="text-align:center;font-weight:700"><?php echo $u['total_orders']; ?></td>
            <td style="color:var(--red);font-weight:600">&#8377;<?php echo number_format($u['pending_pay'],2); ?></td>
            <td style="color:var(--green);font-weight:600">&#8377;<?php echo number_format($u['completed_pay'],2); ?></td>
            <td><a href="admin_users.php?delete=<?php echo $u['id']; ?>" class="delete-btn" onclick="return confirm('Delete this customer account?')" style="padding:.8rem 1.2rem;font-size:1.3rem"><i class="fas fa-trash"></i> Delete</a></td>
          </tr>
        <?php }}else{echo '<tr><td colspan="8" style="text-align:center;padding:4rem;color:var(--muted);font-size:1.6rem">No customers found.</td></tr>';} ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
  </main>
</div>
<script>
function filterUsers(q){document.querySelectorAll('#usersTable tbody tr').forEach(r=>{r.style.display=r.textContent.toLowerCase().includes(q.toLowerCase())?'':'none'});}
document.querySelectorAll('.message').forEach(m=>{setTimeout(()=>{m.style.opacity='0';setTimeout(()=>m.remove(),400)},4000)});
</script>
</body></html>
