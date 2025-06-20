<?php
include('db.php');
session_start();

if (!isset($_GET['id'])) {
    echo "Invalid ad.";
    exit();
}

$ad_id = $_GET['id'];
$sql = "SELECT ads.*, users.name, users.email, users.cell_number 
        FROM ads 
        JOIN users ON ads.user_id = users.user_id
        WHERE ads.ad_id = $ad_id";

$result = mysqli_query($conn, $sql);
$ad = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($ad['title']); ?> - PluggedSA</title>
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
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
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

        .product-image {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
        }

        .chat-button, .wishlist-button {
            border: none;
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: bold;
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
                <li class="nav-item"><a class="nav-link" href="wishlist.php">Wishlist</a></li>
                <li class="nav-item"><a class="nav-link" href="conversation.php?partner_id=<?php echo $ad['user_id']; ?>">Chat</a></li>
            </ul>
            <a class="nav-link text-white" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <img src="<?php echo htmlspecialchars($ad['image_url']); ?>" alt="Product Image" class="product-image mb-3" />
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm">
                <h2 class="mb-3"><?php echo htmlspecialchars($ad['title']); ?></h2>
                <p><?php echo htmlspecialchars($ad['description']); ?></p>
                <p class="fw-bold fs-5 text-success">Price: R<?php echo htmlspecialchars($ad['price']); ?></p>

                <?php if (!empty($ad['rating'])): ?>
                    <p class="text-success">Rating: <?php echo htmlspecialchars($ad['rating']); ?> ⭐</p>
                <?php else: ?>
                    <p class="text-muted">Rating: Not rated yet</p>
                <?php endif; ?>

                <form action="wishlist_action.php" method="POST" class="d-inline">
                    <input type="hidden" name="ad_id" value="<?php echo $ad['ad_id']; ?>">
                    <button type="submit" class="wishlist-button btn btn-primary me-2">Add to Wishlist ❤️</button>
                </form>

                <br>

                <a href="conversation.php?partner_id=<?php echo $ad['user_id']; ?>" class="chat-button btn btn-success">Chat with Seller</a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm">
                <h4>Seller Information</h4>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($ad['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($ad['email']); ?></p>
                <p><strong>Cell Number:</strong> <?php echo htmlspecialchars($ad['cell_number']); ?></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
