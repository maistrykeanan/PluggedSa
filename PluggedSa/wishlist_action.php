<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$ad_id = $_POST['ad_id'];

// Prevent duplicate wishlist entries
$sql_check = "SELECT * FROM wishlist WHERE user_id='$user_id' AND ad_id='$ad_id'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) == 0) {
    // Insert into wishlist
    $sql = "INSERT INTO wishlist (user_id, ad_id) VALUES ('$user_id', '$ad_id')";
    if (mysqli_query($conn, $sql)) {
        header("Location: wishlist.php");
        exit();
    } else {
        echo "Error adding to wishlist: " . mysqli_error($conn);
    }
} else {
    header("Location: wishlist.php"); // If item already exists, redirect
    exit();
}
?>
