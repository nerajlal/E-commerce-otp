<?php
session_start();
include ('includes/dbconnect.php');
include ('includes/header.php');

$result = mysqli_query($conn, "SELECT * FROM products");
?>
<div class="container mt-4">
  <h2 class="mb-4">Products</h2>
  <div class="row">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div class="col-md-3">
        <div class="card mb-4">
          <img src="assets/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['name']; ?></h5>
            <p class="card-text">Price: ₹<?php echo $row['price']; ?></p>
            <form method="POST" action="cart.php">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="add" class="btn btn-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<?php include ('includes/footer.php'); ?>