<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['category']) || empty($_GET['category'])) {
    die("<p class='text-center text-danger mt-4'>No category selected.</p>");
}

$category = mysqli_real_escape_string($conn, $_GET['category']);

$sql_check = "SELECT DISTINCT category FROM ads WHERE category='$category'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) == 0) {
    die("<p class='text-center text-danger mt-4'>Invalid category selected.</p>");
}

$sql = "SELECT * FROM ads WHERE category='$category' ORDER BY ad_id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("<p class='text-center text-danger mt-4'>Database Query Failed: " . mysqli_error($conn) . "</p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars(ucwords($category)); ?> - Listings</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 90px;
        }

        .navbar-custom {
            background-color: #222;
            padding: 10px 20px;
            border-radius: 40px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            position: fixed;
            z-index: 999;
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

        .product-card {
            transition: 0.2s;
        }

        .product-card:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid px-3">
        <a class="navbar-brand" href="index.php">PluggedSA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="categories.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="conversation.php">Chat</a></li>
            </ul>
            <a class="nav-link text-white" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4 text-capitalize"><?php echo htmlspecialchars($category); ?> Listings</h3>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <div class="card product-card h-100">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text small text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="fw-bold text-success mb-1">Price: R<?php echo htmlspecialchars($row['price']); ?></p>
                            <p class="text-secondary small">
                                Rating: <?php echo !empty($row['rating']) ? htmlspecialchars($row['rating']) . " ⭐" : "Not rated yet"; ?>
                            </p>
                            <a href="ad_page.php?id=<?php echo $row['ad_id']; ?>" class="btn btn-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center fs-5 text-muted">No products found in this category.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
