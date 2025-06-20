<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$_SESSION['name'] = $user['name'];
$_SESSION['surname'] = $user['surname'];

$sql_unread = "SELECT COUNT(*) AS unread_count FROM chats WHERE receiver_id='$user_id' AND is_read=0";
$result_unread = mysqli_query($conn, $sql_unread);
$unread_messages = mysqli_fetch_assoc($result_unread)['unread_count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Account - PluggedSA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #F4F4F4;
      padding-top: 90px;
    }

    .navbar-custom {
      background-color: #222;
      padding: 8px 20px;
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 50px;
      width: 1400px;
      max-width: 100%;
      z-index: 999;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .navbar-custom .nav-link,
    .navbar-custom .navbar-brand {
      color: white;
      font-weight: 500;
      padding: 6px 14px;
    }

    .navbar-custom .nav-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 991.98px) {
      .navbar-custom {
        top: 0;
        left: 0;
        transform: none;
        border-radius: 0;
        width: 100%;
      }
    }

    .account-container {
      background: white;
      padding: 30px;
      width: 100%;
      max-width: 500px;
      margin: 30px auto;
      border-radius: 12px;
      box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .account-container h1 {
      font-family: 'Montserrat', sans-serif;
      font-size: 24px;
      color: #2E2E2E;
      margin-bottom: 20px;
    }

    .account-details p {
      font-size: 16px;
      color: #333;
      margin: 8px 0;
    }

    .notification {
      background: #ff4d4d;
      color: white;
      font-weight: bold;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
    }

    .update-form input {
      border-radius: 8px;
    }

    .btn-update {
      background-color: #007BFF;
      border: none;
      color: white;
      font-weight: 500;
      border-radius: 8px;
    }

    .btn-update:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid px-3">
    <a class="navbar-brand" href="index.php">PluggedSA</a>
    <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAccount">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarAccount">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="buy.php">Buy</a></li>
        <li class="nav-item"><a class="nav-link" href="sell.php">Sell</a></li>
        <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="chat.php?seller_id=<?php echo $user_id; ?>">Chat</a></li>
        <li class="nav-item">
          <a class="nav-link active" href="account.php"><?php echo htmlspecialchars($_SESSION['name'] . ' ' . $_SESSION['surname']); ?></a>
        </li>
      </ul>
      <div class="d-flex">
        <a class="nav-link text-white" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</nav>

<!-- Account Details -->
<div class="account-container">
  <h1>My Account</h1>

  <?php if ($unread_messages > 0): ?>
    <div class="notification">
      <a href="chat.php?seller_id=<?php echo $user_id; ?>" style="color: white; text-decoration: none;">
        You have <?php echo $unread_messages; ?> unread messages
      </a>
    </div>
  <?php endif; ?>

  <div class="account-details">
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Surname:</strong> <?php echo htmlspecialchars($user['surname']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Cell Number:</strong> <?php echo htmlspecialchars($user['cell_number']); ?></p>
    <p><strong>User Type:</strong> <?php echo htmlspecialchars($user['user_type']); ?></p>
  </div>

  <h2 class="mt-4">Update Account Information</h2>
  <form method="POST" action="update_account.php" class="update-form text-start mt-3">
    <div class="mb-3">
      <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
    </div>
    <div class="mb-3">
      <input type="text" name="surname" class="form-control" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
    </div>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>
    <div class="mb-4">
      <input type="text" name="cell_number" class="form-control" value="<?php echo htmlspecialchars($user['cell_number']); ?>" required>
    </div>
    <div class="d-grid">
      <button type="submit" class="btn btn-update">Update Account</button>
    </div>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
