<?php
include ('../includes/dbconnect.php');
include ('includes/header.php');
include ('auth.php');
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<div class="container mt-4">
  <h2>Admin - Manage Products</h2>
  <a href="add.php" class="btn btn-success mb-3">Add New Product</a>
  <table class="table table-bordered">
    <thead>
      <tr><th>Name</th><th>Image</th><th>Price</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $row['name'] ?></td>
        <td><img src="../assets/<?= $row['image'] ?>" width="50"></td>
        <td><?= $row['price'] ?></td>
        <td>
          <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include ('../includes/footer.php'); ?>
