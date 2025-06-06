<?php
session_start();
require_once ('includes/dbconnect.php');

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
  header("Location: cart.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $total_price = 0;

  foreach ($_SESSION['cart'] as $id => $qty) {
    $res = mysqli_query($conn, "SELECT price FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($res);
    $total_price += $product['price'] * $qty;
  }

  // Insert order
  mysqli_query($conn, "INSERT INTO orders (user_id, address, total_price) VALUES ($user_id, '$address', $total_price)");
  $order_id = mysqli_insert_id($conn);

  // Insert order items
  foreach ($_SESSION['cart'] as $id => $qty) {
    $res = mysqli_query($conn, "SELECT price FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($res);
    $price = $product['price'];
    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $id, $qty, $price)");
  }

  unset($_SESSION['cart']);

  $success = true;
}

include 'includes/header.php';
?>
<div class="container mt-4">
  <h2 class="mb-4">Checkout</h2>
  <?php if (isset($success)): ?>
    <div class="alert alert-success">Order placed successfully!</div>
    <a href="index.php" class="btn btn-primary">Continue Shopping</a>
  <?php else: ?>
    <form method="POST">
      <div class="mb-3">
        <label for="address" class="form-label">Delivery Address</label>
        <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">Place Order</button>
    </form>
  <?php endif; ?>
</div>
<?php include ('includes/footer.php'); ?>
