<?php

$conn = mysqli_connect("localhost", "root", "", "ecommerce");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>