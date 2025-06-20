<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'seller') {
    header("Location: index.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Fetch seller's ads
$sql_ads = "SELECT * FROM ads WHERE seller_id = '$seller_id'";
$result_ads = mysqli_query($conn, $sql_ads);

// Fetch seller's average rating & total reviews
$sql_avg_rating = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE seller_id='$seller_id'";
$result_avg_rating = mysqli_query($conn, $sql_avg_rating);
$reviews_data = mysqli_fetch_assoc($result_avg_rating);
$average_rating = round($reviews_data['avg_rating'], 1);
$total_reviews = $reviews_data['total_reviews'];

// Fetch reviews for seller
$sql_fetch_reviews = "SELECT reviews.*, users.name FROM reviews JOIN users ON reviews.user_id = users.user_id WHERE seller_id='$seller_id' ORDER BY created_at DESC";
$result_fetch_reviews = mysqli_query($conn, $sql_fetch_reviews);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="post_ad.php">Post Ad</a></li>
                <li><a href="chat.php">Chat</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>My Posted Ads</h1>

        <h2>Seller Rating: <?php echo $average_rating; ?> / 5 ⭐ (<?php echo $total_reviews; ?> Reviews)</h2>

        <div class="ads-container">
            <?php if (mysqli_num_rows($result_ads) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_ads)): ?>
                    <div class="ad-card">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product Image">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p><strong>Price:</strong> $<?php echo htmlspecialchars($row['price']); ?></p>
                        <a href="edit_ad.php?id=<?php echo $row['ad_id']; ?>">Edit</a>
                        <a href="delete_ad.php?id=<?php echo $row['ad_id']; ?>" onclick="return confirm('Are you sure you want to delete this ad?');">Delete</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You have not posted any ads yet.</p>
            <?php endif; ?>
        </div>

        <h2>Customer Reviews</h2>
        <div class="reviews-container">
            <?php if (mysqli_num_rows($result_fetch_reviews) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_fetch_reviews)): ?>
                    <div class="review-box">
                        <p><strong><?php echo htmlspecialchars($row['name']); ?>:</strong></p>
                        <p>Rating: <?php echo str_repeat("⭐", $row['rating']); ?></p>
                        <p>Review: <?php echo htmlspecialchars($row['review_text']); ?></p>
                        <p><small>Posted on <?php echo date("d M Y", strtotime($row['created_at'])); ?></small></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>

