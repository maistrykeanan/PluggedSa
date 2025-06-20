<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch users the logged-in user has chatted with
$sql = "SELECT DISTINCT 
            CASE 
                WHEN sender_id = '$user_id' THEN receiver_id 
                ELSE sender_id 
            END AS chat_partner_id,
            users.name,
            (SELECT message FROM chats WHERE (sender_id = users.user_id OR receiver_id = users.user_id) ORDER BY timestamp DESC LIMIT 1) AS last_message
        FROM chats
        JOIN users ON users.user_id = CASE 
                WHEN sender_id = '$user_id' THEN receiver_id 
                ELSE sender_id 
            END
        WHERE sender_id = '$user_id' OR receiver_id = '$user_id'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages - PluggedSA</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="margin: 0; padding: 0; overflow: auto; height: 100vh;">
    
    <!-- Floating Navigation Bar -->
    <nav style="
        position: fixed; 
        top: 15px; 
        left: 50%;
        transform: translateX(-50%);
        width: 90%; 
        background: rgba(34, 34, 34, 0.95); 
        padding: 15px 40px; 
        border-radius: 50px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3); 
        z-index: 1000;">
        <ul style="list-style: none; display: flex; justify-content: space-around; width: 100%; padding: 0; margin: 0;">
            <li><a href="index.php" style="color: white;">Home</a></li>
            <li><a href="wishlist.php" style="color: white;">Wishlist</a></li>
            <li><a href="logout.php" style="color: white;">Logout</a></li>
        </ul>
    </nav>

    <!-- Messages List -->
    <div style="margin-top: 80px; padding: 20px;">
        <h1>Messages</h1>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div style="padding: 10px; margin-bottom: 10px; background: #f1f1f1; border-radius: 5px;">
                    <a href="conversation.php?partner_id=<?php echo $row['chat_partner_id']; ?>" style="text-decoration: none; color: black; font-size: 18px;">
                        <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                        <span style="font-size: 14px; color: gray;"><?php echo htmlspecialchars($row['last_message']); ?></span>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>
