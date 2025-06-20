<?php
include('db.php');
session_start();

// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@pluggedsa.com') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ad_id'])) {
    $ad_id = intval($_POST['ad_id']); // Sanitize input

    $stmt = $conn->prepare("DELETE FROM ads WHERE ad_id = ?");
    $stmt->bind_param("i", $ad_id);

    if ($stmt->execute()) {
        header("Location: admin_listings.php?deleted=success");
        exit();
    } else {
        header("Location: admin_listings.php?deleted=fail");
        exit();
    }
} else {
    header("Location: admin_listings.php?deleted=invalid");
    exit();
}
