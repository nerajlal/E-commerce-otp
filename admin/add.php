<?php

include ('../includes/dbconnect.php');
include ('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "../assets/$image");

    $sql = "INSERT INTO products (name, image, price) VALUES ('$name', '$image', '$price')";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit();
}
?>

<?php include('includes/header.php');  ?>
    <h2>Add Product</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required pattern="[A-Za-z0-9\s]+" title="Name can only contain letters, numbers, and spaces">
      </div>
      <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" class="form-control" required min="1" title="Please enter a valid price (must be 1 or more)">
      </div>
      <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" accept="image/*" required>
      </div>
      <button type="submit" class="btn btn-success">Add Product</button>
    </form>

    
<?php include('../includes/footer.php');  ?>
