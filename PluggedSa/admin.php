<?php
include('db.php');
session_start();

// Hardcoded admin credentials
$admin_email = "admin@pluggedsa.com";
$admin_password = "admin123";

// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== $admin_email || $_SESSION['password'] !== $admin_password) {
    header("Location: index.php");
    exit();
}

// Fetch analytics data
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$listings_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM ads"))['total'];
$chats_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM chats"))['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - PluggedSA</title>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F4F4F4; margin: 0; text-align: center;">

    <header style="background: #222; padding: 15px; color: white;">
        <nav>
            <a href="index.php" style="color: white; text-decoration: none; margin-right: 20px;">Home</a>
            <a href="logout.php" style="color: white; text-decoration: none;">Logout</a>
        </nav>
    </header>

    <div style="width: 80%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 5px 15px rgba(0,0,0,0.1); margin-top: 20px;">
        <h1>Admin Dashboard</h1>

        <div style="padding: 15px; background: #f8f8f8; border-radius: 8px; box-shadow: 0px 3px 10px rgba(0,0,0,0.1);">
            <p><strong>Active Users:</strong> <?php echo $users_count; ?></p>
            <p><strong>Active Listings:</strong