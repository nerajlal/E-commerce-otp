<?php
session_start();
include('../includes/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = trim($_POST['otp']);
    if (!preg_match('/^\d{4}$/', $entered_otp)) {
        $error = "Invalid OTP format.";
    } else if (!isset($_SESSION['otp'], $_SESSION['mobile'])) {
        $error = "Session expired or invalid access.";
    } else {
        if ($entered_otp === (string)$_SESSION['otp']) {
            $mobile = $_SESSION['mobile'];

            $stmt = $conn->prepare("SELECT id FROM users WHERE mobile = ? ORDER BY id DESC LIMIT 1");
            if (!$stmt) {
                die("Database error: " . $conn->error);
            }
            $stmt->bind_param("s", $mobile);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $user_id = $row['id'];

                $updateStmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE id = ?");
                if (!$updateStmt) {
                    die("Database error: " . $conn->error);
                }
                $updateStmt->bind_param("i", $user_id);
                $updateStmt->execute();

                $_SESSION['user_id'] = $user_id;
                unset($_SESSION['otp']);
                unset($_SESSION['mobile']);

                header("Location: ../index.php");
                exit();
            } else {
                $error = "User not found.";
            }

            $stmt->close();
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Verify OTP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height:100vh;">
  <form method="POST" class="p-4 border rounded shadow-sm w-25">
    <h4>Enter OTP</h4>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <p>Your OTP is: <strong><?php echo $_SESSION['otp']; ?></strong></p>
    <div class="mb-3">
      <label>OTP</label>
      <input type="text" name="otp" class="form-control" required pattern="\d{4}" maxlength="4" minlength="4" title="Please enter a valid 4-digit OTP">
    </div>
    <button type="submit" class="btn btn-success w-100">Verify</button>
  </form>
</body>
</html>
