<?php
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['receiver_id'], $_POST['message'])) {
    $sender_id   = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message     = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO chats (sender_id, receiver_id, message, is_read) 
            VALUES ('$sender_id', '$receiver_id', '$message', 0)";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: conversation.php?partner_id=$receiver_id");
        exit();
    } else {
        echo "Error sending message: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
