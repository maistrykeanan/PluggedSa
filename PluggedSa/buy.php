<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all products from the database
$sql = "SELECT * FROM ads ORDER BY ad_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Buy Products - PluggedSA</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding-top: 90px;
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background-color: #333;
            padding: 8px 20px;
            position: fixed;
            top: 0px;
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
            margin-top: 20px;
            font-weight: 600;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 30px;
            padding: 40px 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .product-description {
            font-size: 14px;
            color: #555;
            min-height: 60px;
        }

        .product-price {
            font-weight: bold;
            margin-top: 10px;
            color: #007BFF;
        }

        .product-button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background-color: #007BFF;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }

        .product-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Floating Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="index.php">PluggedSA</a>
            <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBuy">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarBuy">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="buy.php">Buy</a></li>
                    <li class="nav-item"><a class="nav-link" href="sell.php">Sell</a></li>
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

    <!-- Products Section -->
    <main>
        <h1>Available Products</h1>
        <div class="product-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product Image">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p class="product-description"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="product-price">Price: R<?php echo htmlspecialchars($row['price']); ?></p>
                        <a href="ad_page.php?id=<?php echo $row['ad_id']; ?>" class="product-button">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center mt-4">No products listed yet. Be the first to post a product!</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
