<?php
include('db.php');
session_start();

// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@pluggedsa.com') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($type === 'ad') {
        mysqli_query($conn, "DELETE FROM ads WHERE ad_id='$id'");
    } elseif ($type === 'user') {
        mysqli_query($conn, "DELETE FROM users WHERE user_id='$id'");
        mysqli_query($conn, "DELETE FROM ads WHERE seller_id='$id'"); // Remove user's ads
        mysqli_query($conn, "DELETE FROM chats WHERE sender_id='$id' OR receiver_id='$id'"); // Remove user's chats
    }

    header("Location: admin.php");
    exit();
}
?>
