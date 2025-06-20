<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$ad_id = $_POST['ad_id'];

$sql = "DELETE FROM wishlist WHERE user_id='$user_id' AND ad_id='$ad_id'";
if (mysqli_query($conn, $sql)) {
    header("Location: wishlist.php"); // Redirect back after removal
    exit();
} else {
    echo "Error removing from wishlist: " . mysqli_error($conn);
}
?>
