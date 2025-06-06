<?php
include ('../includes/dbconnect.php');
include ('auth.php');

$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/$image");
        $query = "UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id";
    } else {
        $query = "UPDATE products SET name='$name', price='$price' WHERE id=$id";
    }

    mysqli_query($conn, $query);
    header("Location: index.php");
    exit();
}
?>

<?php include('includes/header.php');  ?>

    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" 
              value="<?= htmlspecialchars($product['name']) ?>" 
              required pattern="[A-Za-z0-9\s]+" 
              title="Name can only contain letters, numbers, and spaces">
      </div>
      <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" class="form-control" 
              value="<?= htmlspecialchars($product['price']) ?>" 
              required min="1" step="0.01"
              title="Enter a valid price (e.g., 99.99)">
      </div>
      <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <?php if (!empty($product['image'])): ?>
          <img src="../assets/<?= htmlspecialchars($product['image']) ?>" width="100" class="mt-2">
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  
<?php include('../includes/footer.php');  ?>