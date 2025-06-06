<?php
session_start();
include('../includes/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = trim($_POST['mobile']);
    if (!preg_match('/^\d{10,15}$/', $mobile)) {
        die('Invalid mobile number format.');
    }

    $otp = random_int(1000, 9999);

    $_SESSION['otp'] = $otp;
    $_SESSION['mobile'] = $mobile;

    $stmt = $conn->prepare("INSERT INTO users (mobile, otp, is_verified) VALUES (?, ?, 0)");
    if (!$stmt) {
        die('Database error: ' . $conn->error);
    }
    $stmt->bind_param('si', $mobile, $otp); 

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: verify.php");
        exit();
    } else {
        die('Database error: ' . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>OTP Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 400px;">
      <form method="POST" class="p-4 border rounded shadow-sm bg-white">
        <h4 class="mb-3 text-center">Login via OTP</h4>
        <div class="mb-3">
          <label class="form-label">Mobile Number</label>
          <input type="text" name="mobile" class="form-control" required pattern="\d{10}" maxlength="10"    minlength="10" title="Please enter a valid 10-digit mobile number">
        </div>
        <button type="submit" class="btn btn-primary w-100">Generate OTP</button>
      </form>
    </div>
  </div>
</body>
</html>
