<?php
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $cell_number = $_POST['cell_number'];

    $sql = "UPDATE users SET name='$name', surname='$surname', email='$email', cell_number='$cell_number' 
            WHERE user_id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Your information has been updated successfully!'); window.location.href='account.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating account. Please try again.'); window.location.href='account.php';</script>";
    }
}
?>

