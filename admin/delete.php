<?php
include '../includes/dbconnect.php';
include 'auth.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM products WHERE id = $id");

header("Location: index.php");
exit();
