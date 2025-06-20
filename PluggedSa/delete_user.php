<?php
include('db.php');
session_start();

// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@pluggedsa.com') {
    die("<p style='color:red;'>Error: Unauthorized access.</p>");
}

// Check if user_id was sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    // Delete user from database
    $sql_delete = "DELETE FROM users WHERE user_id = '$user_id'";
    $delete_result = mysqli_query($conn, $sql_delete);

    if ($delete_result) {
        echo "<p style='color:green;'>User deleted successfully!</p>";
        header("Location: admin_users.php"); // Redirect back to users page
        exit();
    } else {
        echo "<p style='color:red;'>Error deleting user: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:red;'>Invalid request.</p>";
}
?>
