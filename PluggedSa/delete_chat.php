<?php
include('db.php');
session_start();

// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@pluggedsa.com') {
    die("<p style='color:red;'>Error: Unauthorized access.</p>");
}

// Check if chat_id was sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chat_id'])) {
    $chat_id = mysqli_real_escape_string($conn, $_POST['chat_id']);

    // Delete chat from database
    $sql_delete = "DELETE FROM chats WHERE chat_id = '$chat_id'";
    $delete_result = mysqli_query($conn, $sql_delete);

    if ($delete_result) {
        echo "<p style='color:green;'>Chat message deleted successfully!</p>";
        header("Location: admin_chats.php"); // Redirect back to chats page
        exit();
    } else {
        echo "<p style='color:red;'>Error deleting chat message: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:red;'>Invalid request.</p>";
}
?>
