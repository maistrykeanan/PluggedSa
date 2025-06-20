<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch wishlist items
$sql = "SELECT ads.* FROM wishlist 
        JOIN ads ON wishlist.ad_id = ads.ad_id 
        WHERE wishlist.user_id='$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Wishlist - PluggedSA</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 90px;
            background-color: #f8f9fa;
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

        .wishlist-card {
            transition: 0.2s;
        }

        .wishlist-card:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .remove-button {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 18px;
            font-weight: bold;
        }

        .remove-button:hover {
            background-color: #bb2d3b;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid px-3">
        <a class="navbar-brand" href="index.php">PluggedSA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarWishlist">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarWishlist">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link active" href="wishlist.php">Wishlist</a></li>
            </ul>
            <a class="nav-link text-white" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4">My Wishlist ❤️</h3>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <div class="card wishlist-card h-100">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text small text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="fw-bold text-success mb-2">Price: R<?php echo htmlspecialchars($row['price']); ?></p>

                            <form action="remove_wishlist.php" method="POST" class="mb-2">
                                <input type="hidden" name="ad_id" value="<?php echo $row['ad_id']; ?>">
                                <button type="submit" class="remove-button">Remove ❌</button>
                            </form>

                            <a href="ad_page.php?id=<?php echo $row['ad_id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center fs-5 text-muted">Your wishlist is empty.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
