<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mini eCommerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Mini eShop</a>
    <div class="d-flex">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="cart.php" class="btn btn-outline-light me-2">Cart</a>
        <a href="auth/logout.php" class="btn btn-outline-light">Logout</a>
      <?php else: ?>
        <a href="auth/login.php" class="btn btn-outline-light">Login</a>
        <a href="admin/login.php" class="btn btn-outline-light">Admin</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container" style="min-height: 90vh;">
