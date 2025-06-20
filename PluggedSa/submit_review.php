<?php
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $seller_id = $_POST['seller_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];

    $sql = "INSERT INTO reviews (user_id, seller_id, rating, review_text) 
            VALUES ('$user_id', '$seller_id', '$rating', '$review_text')";

    if (mysqli_query($conn, $sql)) {
        header("Location: seller_profile.php?seller_id=$seller_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
