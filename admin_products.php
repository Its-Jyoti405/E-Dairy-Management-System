<?php
include 'config.php'; session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){header('location:login.php');}
if(isset($_POST['add_product'])){
  $name=mysqli_real_escape_string($conn,$_POST['name']);$price=$_POST['price'];
  $avail=(int)($_POST['availability']??1);
  $image=$_FILES['image']['name'];$imgt=$_FILES['image']['tmp_name'];$imgs=$_FILES['image']['size'];
  $chk=mysqli_query($conn,"SELECT id FROM `products` WHERE name='$name'");
  if(mysqli_num_rows($chk)>0){$message[]='A product with this name already exists.';}
  else{
    $q=mysqli_query($conn,"INSERT INTO `products`(name,price,image,availability) VALUES('$name','$price','$image','$avail')") or die('query failed');
    if($q){if($imgs>1000000){$message[]='Image too large (max 1MB). Product added without image.';}else{move_uploaded_file($imgt,'uploaded_img/'.$image);$message[]='Product added successfully!';}}
  }
}
if(isset($_GET['delete'])){$di=(int)$_GET['delete'];$ix=mysqli_query($conn,"SELECT image FROM `products` WHERE id='$di'");$ir=mysqli_fetch_assoc($ix);@unlink('uploaded_img/'.$ir['image']);mysqli_query($conn,"DELETE FROM `products` WHERE id='$di'");header('location:admin_products.php');}
if(isset($_POST['disable_product'])){mysqli_query($conn,"UPDATE `products` SET availability=0 WHERE id='".(int)$_POST['product_id']."'");header('location:admin_products.php');}
if(isset($_POST['enable_product'])){mysqli_query($conn,"UPDATE `products` SET availability=1 WHERE id='".(int)$_POST['product_id']."'");header('location:admin_products.php');}
if(isset($_POST['update_product'])){
  $uid=(int)$_POST['update_p_id'];$un=mysqli_real_escape_string($conn,$_POST['update_name']);
  $up=$_POST['update_price'];$ua=($_POST['update_availability']=='available')?1:0;
  mysqli_query($conn,"UPDATE `products` SET name='$un',price='$up',availability='$ua' WHERE id='$uid'");
  $ui=$_FILES['update_image']['name'];$uit=$_FILES['update_image']['tmp_name'];$uis=$_FILES['update_image']['size'];$uold=$_POST['update_old_image'];
  if(!empty($ui)){if($uis>2000000){$message[]='Image too large.';}else{mysqli_query($conn,"UPDATE `products` SET image='$ui' WHERE id='$uid'");move_uploaded_file($uit,'uploaded_img/'.$ui);@unlink('uploaded_img/'.$uold);}}
  header('location:admin_products.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Products — Milky Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>
<div class="admin-topbar">
  <h1><i class="fas fa-boxes"></i> Products</h1>
</div>
<div class="admin-content">
  <div style="display:grid;grid-template-columns:1fr 2fr;gap:3rem;align-items:start;flex-wrap:wrap">
    <!-- Add Form -->
    <div class="admin-form">
      <h2><i class="fas fa-plus-circle" style="color:var(--amber);margin-right:.6rem"></i> Add Product</h2>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="field"><label>Product Name</label><input type="text" name="name" placeholder="e.g. Fresh Cow Milk" required></div>
        <div class="field"><label>Price (&#8377;)</label><input type="number" min="0" name="price" placeholder="e.g. 60" required></div>
        <div class="field"><label>Availability</label>
          <select name="availability"><option value="1">Available</option><option value="0">Unavailable</option></select>
        </div>
        <div class="field"><label>Product Image <small style="color:var(--muted)">(max 1 MB)</small></label><input type="file" name="image" accept="image/*" required></div>
        <div class="field-actions"><input type="submit" name="add_product" value="Add Product" class="btn"></div>
      </form>
    </div>
    <!-- Products Grid -->
    <div>
      <h2 style="font-family:'Playfair Display',serif;font-size:2.4rem;color:var(--dark);margin-bottom:2rem">All Products (<?php echo mysqli_num_rows(mysqli_query($conn,"SELECT id FROM `products`")); ?>)</h2>
      <div class="product-grid">
        <?php
        $ps=mysqli_query($conn,"SELECT * FROM `products`") or die('query failed');
        if(mysqli_num_rows($ps)>0){while($p=mysqli_fetch_assoc($ps)){ ?>
        <div class="pcard">
          <img src="uploaded_img/<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="<?php echo $p['availability']?'':'disabled-img'; ?>">
          <div class="pcard-body">
            <div class="pcard-name"><?php echo htmlspecialchars($p['name']); ?></div>
            <div class="pcard-price">&#8377;<?php echo $p['price']; ?></div>
            <span class="pill <?php echo $p['availability']?'pill-complete':'pill-pending'; ?>" style="margin-bottom:1.2rem">
              <i class="fas <?php echo $p['availability']?'fa-check-circle':'fa-times-circle'; ?>"></i>
              <?php echo $p['availability']?'In Stock':'Unavailable'; ?>
            </span>
            <div class="pcard-actions">
              <form action="" method="post" style="display:contents">
                <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                <?php if($p['availability']): ?>
                  <button type="submit" name="disable_product" class="delete-btn" style="padding:.8rem 1rem;font-size:1.3rem"><i class="fas fa-ban"></i> Disable</button>
                <?php else: ?>
                  <button type="submit" name="enable_product" class="option-btn" style="padding:.8rem 1rem;font-size:1.3rem"><i class="fas fa-check"></i> Enable</button>
                <?php endif; ?>
              </form>
              <a href="admin_products.php?update=<?php echo $p['id']; ?>" class="sky-btn" style="padding:.8rem 1rem;font-size:1.3rem"><i class="fas fa-edit"></i></a>
              <a href="admin_products.php?delete=<?php echo $p['id']; ?>" class="delete-btn" style="padding:.8rem 1rem;font-size:1.3rem" onclick="return confirm('Delete this product permanently?')"><i class="fas fa-trash"></i></a>
            </div>
          </div>
        </div>
        <?php }}else{echo '<p class="empty">No products yet. Add your first product.</p>';} ?>
      </div>
    </div>
  </div>

  <!-- Edit Panel -->
  <?php if(isset($_GET['update'])){ $uid=(int)$_GET['update']; $uq=mysqli_query($conn,"SELECT * FROM `products` WHERE id='$uid'"); if(mysqli_num_rows($uq)>0){$fu=mysqli_fetch_assoc($uq); ?>
  <div style="margin-top:3rem" class="admin-form">
    <h2><i class="fas fa-edit" style="color:var(--amber);margin-right:.6rem"></i> Edit Product</h2>
    <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:2rem">
      <img src="uploaded_img/<?php echo $fu['image']; ?>" alt="" style="width:10rem;height:10rem;object-fit:cover;border-radius:var(--r-md);border:2px solid var(--border)">
      <p style="font-size:1.5rem;color:var(--muted)">Current image of <strong><?php echo htmlspecialchars($fu['name']); ?></strong></p>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fu['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fu['image']; ?>">
      <div class="form-row">
        <div class="field"><label>Product Name</label><input type="text" name="update_name" value="<?php echo htmlspecialchars($fu['name']); ?>" required></div>
        <div class="field"><label>Price (&#8377;)</label><input type="number" name="update_price" value="<?php echo $fu['price']; ?>" min="0" required></div>
      </div>
      <div class="form-row">
        <div class="field"><label>Availability</label>
          <select name="update_availability">
            <option value="available" <?php echo $fu['availability']?'selected':''; ?>>Available</option>
            <option value="unavailable" <?php echo !$fu['availability']?'selected':''; ?>>Unavailable</option>
          </select>
        </div>
        <div class="field"><label>New Image <small style="color:var(--muted)">(optional)</small></label><input type="file" name="update_image" accept="image/*"></div>
      </div>
      <div class="field-actions">
        <input type="submit" name="update_product" value="Save Changes" class="btn">
        <a href="admin_products.php" class="option-btn"><i class="fas fa-times"></i> Cancel</a>
      </div>
    </form>
  </div>
  <?php }} ?>
</div>
  </main>
</div>
<script>document.querySelectorAll('.message').forEach(m=>{setTimeout(()=>{m.style.opacity='0';setTimeout(()=>m.remove(),400)},4000)});</script>
</body></html>