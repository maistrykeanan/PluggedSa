<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $user_id = $_SESSION['user_id'];

    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES["image"]["tmp_name"]);

        if (!in_array($file_type, $allowed_types)) {
            $message = "Only JPG, PNG, and GIF files are allowed.";
        } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        } else {
            $message = "Image upload failed.";
        }
    } else {
        $image_url = "uploads/default.jpg";
    }

    if (empty($message)) {
        $sql = "INSERT INTO ads (title, description, price, image_url, user_id, category) 
                VALUES ('$title', '$description', '$price', '$image_url', '$user_id', '$category')";

        if (mysqli_query($conn, $sql)) {
            header("Location: buy.php");
            exit();
        } else {
            $message = "Error listing product: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sell Your Product - PluggedSA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
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
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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

    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    .sell-form {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .error-message {
      color: red;
      font-weight: 500;
      text-align: center;
      margin-bottom: 15px;
    }

    .sell-button {
      background-color: #007BFF;
      color: white;
      border: none;
      padding: 12px;
      font-weight: 500;
      border-radius: 8px;
    }

    .sell-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<!-- Floating Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid px-3">
    <a class="navbar-brand" href="index.php">PluggedSA</a>
    <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSell">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarSell">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="buy.php">Buy</a></li>
        <li class="nav-item"><a class="nav-link active" href="sell.php">Sell</a></li>
        <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="messages.php">Chat</a></li>
        <li class="nav-item"><a class="nav-link" href="account.php">User Account</a></li>
      </ul>
      <div class="d-flex">
        <a class="nav-link text-white" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</nav>

<!-- Sell Form Content -->
<main class="container my-5">
  <h1>List Your Product</h1>

  <?php if ($message): ?>
    <p class="error-message"><?php echo $message; ?></p>
  <?php endif; ?>

  <form class="sell-form mx-auto" style="max-width: 600px;" action="sell.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="title" class="form-label">Product Title:</label>
      <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description:</label>
      <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Price:</label>
      <input type="number" name="price" id="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="category" class="form-label">Select Category:</label>
      <select name="category" id="category" class="form-select" required>
        <option value="electronics">Electronics</option>
        <option value="fashion">Fashion</option>
        <option value="automotive">Automotive</option>
        <option value="home">Home & Living</option>
      </select>
    </div>

    <div class="mb-4">
      <label for="image" class="form-label">Upload Image:</label>
      <input type="file" name="image" id="image" class="form-control" accept="image/jpeg, image/png, image/gif" required>
    </div>

    <div class="d-grid">
      <button type="submit" class="sell-button">Post Product</button>
    </div>
  </form>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
