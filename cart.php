<?php
session_start();
require_once('includes/dbconnect.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: auth/login.php");
  exit();
}

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Add to cart
if (isset($_POST['add'])) {
  $product_id = $_POST['product_id'];
  if (!isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] = 1;
  } else {
    $_SESSION['cart'][$product_id]++;
  }
  header("Location: cart.php");
  exit();
}

// Remove from cart
if (isset($_GET['remove'])) {
  $remove_id = $_GET['remove'];
  unset($_SESSION['cart'][$remove_id]);
  header("Location: cart.php");
  exit();
}

include('includes/header.php');
?>

<div class="container mt-4 mb-5">
  <h2 class="mb-4">Your Cart</h2>

  <?php if (empty($_SESSION['cart'])): ?>
    <div class="alert alert-info">Your cart is empty.</div>
  <?php else: ?>
    <table class="table table-bordered table-sm align-middle">
      <thead class="table-light">
        <tr>
          <th style="width: 30%">Product</th>
          <th style="width: 15%" class="text-center">Qty</th>
          <th style="width: 15%" class="text-end">Price</th>
          <th style="width: 15%" class="text-end">Total</th>
          <th style="width: 15%" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $qty):
          $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
          $stmt->bind_param("i", $id); 
          $stmt->execute();
          $result = $stmt->get_result();
          $product = $result->fetch_assoc();
          $stmt->close();
          $subtotal = $product['price'] * $qty;
          $total += $subtotal;
        ?>
        <tr>
          <td class="text-wrap"><?php echo htmlspecialchars($product['name']); ?></td>
          <td class="text-center"><?php echo $qty; ?></td>
          <td class="text-end">₹<?php echo number_format($product['price'], 2); ?></td>
          <td class="text-end">₹<?php echo number_format($subtotal, 2); ?></td>
          <td class="text-center">
            <a href="cart.php?remove=<?php echo $id; ?>" class="btn btn-sm btn-danger">Remove</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 gap-3">
      <h4 class="mb-0">Total: ₹<?php echo number_format($total, 2); ?></h4>
      <a href="checkout.php" class="btn btn-success btn-lg">Proceed to Checkout</a>
    </div>
  <?php endif; ?>
</div>


<?php include('includes/footer.php'); ?>
