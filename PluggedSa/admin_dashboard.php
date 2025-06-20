<?php
include('db.php');
session_start();

// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@pluggedsa.com') {
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
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F4F4F4;
            margin: 0;
            text-align: center;
        }
        .navbar {
            background: #222;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        .dashboard-image {
            width: 100%;
            max-height: 200px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .dashboard-btn {
            width: 220px;
            padding: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }
        .dashboard-btn:hover {
            opacity: 0.85;
        }
        .users-btn { background: #007BFF; color: white; }
        .listings-btn { background: #28a745; color: white; }
        .chats-btn { background: #ffc107; color: black; }
    </style>
</head>
<body>

    <header class="navbar">
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </header>

    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Add an image above the buttons -->
        <img src="admin.png" alt="Dashboard Overview" class="dashboard-image">

        <div class="btn-container">
            <a href="admin_users.php">
                <button class="dashboard-btn users-btn">Manage Users (<?php echo $users_count; ?>)</button>
            </a>
            <a href="admin_listings.php">
                <button class="dashboard-btn listings-btn">Manage Listings (<?php echo $listings_count; ?>)</button>
            </a>
            <a href="admin_chats.php">
                <button class="dashboard-btn chats-btn">Manage Chats (<?php echo $chats_count; ?>)</button>
            </a>
        </div>
    </div>

</body>
</html>





