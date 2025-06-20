<?php
include('db.php');
session_start();

// Restrict access to admin
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@pluggedsa.com') {
    header("Location: index.php");
    exit();
}

// Debug: Confirm database connection
if (!$conn) {
    die("<p style='color:red;'>Error: Database connection failed. " . mysqli_connect_error() . "</p>");
}

// Fetch all users
$sql_users = "SELECT user_id, name, surname, email, cell_number, password, user_type FROM users ORDER BY user_id DESC";
$users_result = mysqli_query($conn, $sql_users);

// Debug: Check if query executed
if (!$users_result) {
    die("<p style='color:red;'>Error fetching users: " . mysqli_error($conn) . "</p>");
}

// Debug: Ensure users exist before HTML loads
$user_count = mysqli_num_rows($users_result);
if ($user_count === 0) {
    echo "<p style='color:red;'>No users found in the database.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Admin Panel</title>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F4F4F4; text-align: center;">

    <header style="background: #222; padding: 15px; color: white;">
        <nav>
            <a href="admin_dashboard.php" style="color: white; text-decoration: none; font-size: 18px;">← Back to Dashboard</a>
        </nav>
    </header>

    <div style="width: 90%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 5px 15px rgba(0,0,0,0.1); margin-top: 20px;">
        <h1>Manage Users</h1>

        <?php if ($user_count > 0): ?>
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #007BFF; color: white;">
                        <th style="padding: 10px; border: 1px solid #ccc;">User ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Name</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Surname</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Email</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Cell Number</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Password</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">User Type</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Action</th> <!-- Added Delete Column -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($user['name']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($user['surname']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($user['cell_number']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($user['password']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($user['user_type']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <form action="delete_user.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
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
        <a href="admin_dashboard.php" style="padding: 10px 20px; background: #007BFF; color: white; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>
    </div>

</body>
</html>



