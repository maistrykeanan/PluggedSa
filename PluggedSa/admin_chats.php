<?php
include('db.php');
session_start();



// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@pluggedsa.com') {
    die("<p style='color:red; font-size:18px;'>Error: Unauthorized access.</p>");
}

// Fetch all chat messages with updated table structure
$sql_chats = "SELECT chat_id, sender_id, receiver_id, message, timestamp, is_read FROM chats ORDER BY timestamp DESC";
$chats_result = mysqli_query($conn, $sql_chats);



// Debug: Check if chats exist in the table
$chats_count = mysqli_num_rows($chats_result);
if ($chats_count === 0) {
    echo "<p style='color:red; font-size:18px;'>No chat messages found in the database.</p>";
} else {
    echo "<p style='color:green; font-x;'>Total chat messages found: $chats_count</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Chats - Admin Panel</title>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F4F4F4; text-align: center;">

    <header style="background: #222; padding: 15px; color: white;">
        <nav>
            <a href="admin_dashboard.php" style="color: white; text-decoration: none; font-size: 18px;">← Back to Dashboard</a>
        </nav>
    </header>

    <div style="width: 90%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 5px 15px rgba(0,0,0,0.1); margin-top: 20px;">
        <h1>Manage Chats</h1>

        <?php if ($chats_count > 0): ?>
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #ffc107; color: black;">
                        <th style="padding: 10px; border: 1px solid #ccc;">Chat ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Sender ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Receiver ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Message</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Sent At</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Read Status</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Action</th> <!-- Delete Button Column -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($chat = mysqli_fetch_assoc($chats_result)): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($chat['chat_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($chat['sender_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($chat['receiver_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($chat['message']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($chat['timestamp']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <?php echo ($chat['is_read'] == 1) ? '✔ Read' : '❌ Unread'; ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <form action="delete_chat.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="chat_id" value="<?php echo htmlspecialchars($chat['chat_id']); ?>">
                                    <button type="submit" style="background: #dc3545; color: white; padding: 5px; border: none; border-radius: 5px; cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <br>
        <a href="admin_dashboard.php" style="padding: 10px 20px; background: #ffc107; color: black; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>
    </div>

</body>
</html>
