<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Categories - PluggedSA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS (for mobile collapse) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      background-color: #f8f9fa;
      padding-top: 80px;
    }

    .navbar-custom {
  background-color: #333;
  padding: 8px 20px;
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 40px;
  width: 1500px;
  max-width: 100%;
  z-index: 1200;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.navbar-custom .nav-link,
.navbar-custom .navbar-brand {
  color: white;
  font-weight: 500;
  padding: 6px 12px;
}


    .navbar-custom .nav-link:hover {
      text-decoration: underline;
    }

    /* Mobile Toggler (shown only on small screens) */
    @media (max-width: 991.98px) {
      .navbar-custom {
        top: 0;
        left: 0;
        transform: none;
        border-radius: 0;
        width: 100%;
      }
    }

    /* Category Grid */
    .category-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 30px;
      padding: 40px 20px;
    }

    .category-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease;
    }

    .category-card:hover {
      transform: translateY(-4px);
    }

    .category-card img {
      width: 100%;
      max-height: 150px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .category-card h2 {
      font-size: 20px;
      margin-bottom: 10px;
      color: #222;
    }

    .category-card p {
      font-size: 14px;
      color: #555;
    }

    .category-button {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 18px;
      background-color: #007BFF;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
    }

    .category-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<!-- Floating Navbar with Collapse Support -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid px-3">
    <a class="navbar-brand" href="index.php">PluggedSA</a>

    <!-- Hamburger toggle button -->
    <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarItems">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarItems">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="buy.php">Buy</a></li>
        <li class="nav-item"><a class="nav-link" href="sell.php">Sell</a></li>
        <li class="nav-item"><a class="nav-link active" href="categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="messages.php">Chat</a></li>
        <li class="nav-item"><a class="nav-link" href="account.php">User Account</a></li>
      </ul>
      <div class="d-flex">
        <a class="nav-link text-white" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</nav>

<!-- Page Content -->
<main>
  <h1 class="text-center mb-4">Explore Categories</h1>
  <div class="category-grid">

    <div class="category-card">
      <img src="electronics.jpeg" alt="Electronics">
      <h2>Electronics</h2>
      <p>Find the latest gadgets, laptops, phones, and accessories.</p>
      <a href="category_view.php?category=electronics" class="category-button">View Category</a>
    </div>

    <div class="category-card">
      <img src="fashion.jpeg" alt="Fashion">
      <h2>Fashion</h2>
      <p>Browse clothing, shoes, accessories, and trending styles.</p>
      <a href="category_view.php?category=fashion" class="category-button">View Category</a>
    </div>

    <div class="category-card">
      <img src="automotive.jpg" alt="Automotive">
      <h2>Automotive</h2>
      <p>Buy and sell cars, parts, and vehicle accessories.</p>
      <a href="category_view.php?category=automotive" class="category-button">View Category</a>
    </div>

    <div class="category-card">
      <img src="home.jpeg" alt="Home & Living">
      <h2>Home & Living</h2>
      <p>Shop furniture, decor, and household essentials.</p>
      <a href="category_view.php?category=home" class="category-button">View Category</a>
    </div>

  </div>
</main>

<!-- Bootstrap JS for navbar toggling -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

