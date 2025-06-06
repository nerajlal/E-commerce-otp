<?php
session_start();

$admin_username = 'admin';
$admin_password = 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: index.php");
    exit();
  } else {
    $error = "Invalid credentials";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 400px;">
      <form method="POST" class="p-4 border rounded shadow bg-white">
        <h4 class="mb-3 text-center">Admin Login</h4>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
