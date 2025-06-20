<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$chat_partner_id = isset($_GET['partner_id']) ? intval($_GET['partner_id']) : null;

// If partner is NOT selected, show message list
$show_convo_list = (!$chat_partner_id || $chat_partner_id == $user_id);
if ($show_convo_list) {
    $sql = "SELECT DISTINCT 
                CASE WHEN sender_id = '$user_id' THEN receiver_id ELSE sender_id END AS chat_partner_id,
                users.name,
                (SELECT message FROM chats 
                 WHERE (sender_id = users.user_id OR receiver_id = users.user_id)
                   AND (sender_id = '$user_id' OR receiver_id = '$user_id')
                 ORDER BY timestamp DESC LIMIT 1) AS last_message
            FROM chats
            JOIN users ON users.user_id = CASE 
                WHEN sender_id = '$user_id' THEN receiver_id ELSE sender_id END
            WHERE sender_id = '$user_id' OR receiver_id = '$user_id'";

    $result = mysqli_query($conn, $sql);
} else {
    // Otherwise, show specific conversation
    mysqli_query($conn, "UPDATE chats SET is_read = 1 WHERE receiver_id = '$user_id' AND sender_id = '$chat_partner_id'");
    $result = mysqli_query($conn, "SELECT * FROM chats 
        WHERE (sender_id = $user_id AND receiver_id = $chat_partner_id) 
        OR (sender_id = $chat_partner_id AND receiver_id = $user_id)
        ORDER BY timestamp ASC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages - PluggedSA</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #333;
            border-radius: 40px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            z-index: 999;
            position: fixed;
            padding: 10px 20px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.3);
        }
        @media (max-width: 768px) {
            .navbar-custom {
                border-radius: 0;
                top: 0;
                left: 0;
                transform: none;
                width: 100%;
            }
        }

        body {
            padding-top: 90px;
            background-color: #f8f9fa;
        }

        .chat-bubble {
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 15px;
            max-width: 75%;
            word-wrap: break-word;
            margin-bottom: 10px;
        }

        .sent {
            background-color: #4CAF50;
            color: white;
            align-self: end;
            border-radius: 20px 20px 0 20px;
        }

        .received {
            background-color: #e4e4e4;
            color: black;
            align-self: start;
            border-radius: 20px 20px 20px 0;
        }

        .chat-window {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 20px;
            margin: auto;
            max-width: 700px;
        }

        .chat-input-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            padding: 20px;
            max-width: 700px;
            margin: auto;
        }

        .chat-input {
            flex: 1;
            padding: 12px;
            border-radius: 30px;
            border: 1px solid #ccc;
        }

        .chat-submit {
            padding: 12px 24px;
            border-radius: 30px;
            border: none;
            background: #007bff;
            color: white;
            font-weight: bold;
        }

        .chat-submit:hover {
            background: #0056b3;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card-link:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid px-3">
        <a class="navbar-brand" href="index.php">PluggedSA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navToggle">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="conversation.php">Messages</a></li>
            </ul>
            <a class="nav-link text-white" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<?php if ($show_convo_list): ?>
    <div class="container mt-4">
        <h3 class="mb-4">Conversations</h3>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <a href="conversation.php?partner_id=<?php echo $row['chat_partner_id']; ?>" class="card-link">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text text-muted small"><?php echo htmlspecialchars($row['last_message']); ?></p>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="chat-window">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="chat-bubble <?php echo ($row['sender_id'] == $user_id) ? 'sent align-self-end' : 'received align-self-start'; ?>">
                <?php echo htmlspecialchars($row['message']); ?><br>
                <small class="text-muted"><?php echo date('H:i', strtotime($row['timestamp'])); ?></small>
            </div>
        <?php endwhile; ?>
    </div>

    <form method="POST" action="send_message.php">
        <input type="hidden" name="receiver_id" value="<?php echo $chat_partner_id; ?>">
        <div class="chat-input-container">
            <input type="text" name="message" class="chat-input" placeholder="Type a message..." required>
            <button type="submit" class="chat-submit">Send</button>
        </div>
    </form>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
