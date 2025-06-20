<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>About Us - PluggedSA</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding-top: 90px;
    }

    .navbar-custom {
      background-color: #333;
      padding: 8px 20px;
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 40px;
      width: 1400px;
      max-width: 100%;
      z-index: 999;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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

    .about-us-image img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .about-us-text h1 {
      font-size: 28px;
      color: #2E2E2E;
    }

    .about-us-text p {
      font-size: 16px;
      line-height: 1.6;
      color: #444;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid px-3">
    <a class="navbar-brand" href="index.php">PluggedSA</a>
    <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHome">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarHome">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="buy.php">Buy</a></li>
        <li class="nav-item"><a class="nav-link" href="sell.php">Sell</a></li>
        <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="messages.php">Chat</a></li>
        <li class="nav-item"><a class="nav-link" href="wishlist.php">Wishlist</a></li>
        <li class="nav-item">
          <a class="nav-link" href="account.php">
            <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : "User Account"; ?>
          </a>
        </li>
      </ul>
      <div class="d-flex">
        <a class="nav-link text-white" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container my-5">
  <div class="row align-items-center gy-4">
    <div class="col-lg-6">
      <div class="about-us-image">
        <?php if (file_exists("home.png")): ?>
          <img src="home.png" alt="Welcome to PluggedSA" class="img-fluid">
        <?php else: ?>
          <p class="text-danger">⚠️ Banner image missing (home.png)</p>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-lg-6 about-us-text">
      <h1>Welcome, <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : "Guest"; ?>!</h1>
      <p>PluggedSA is a modern customer-to-customer marketplace where buyers and sellers connect seamlessly.</p>
      <p>Our platform enables users to list, discover, and purchase products in an elegant, structured environment.</p>
      <p>Whether you're looking to buy or sell, our secure and intuitive platform ensures a smooth experience.</p>
      <p>Join us in transforming online trading into a refined, user-friendly experience!</p>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
