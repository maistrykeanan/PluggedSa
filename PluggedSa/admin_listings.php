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

// Fetch all listings
$sql_listings = "SELECT ad_id, seller_id, title, price, description, image_url, rating, category, user_id FROM ads ORDER BY ad_id DESC";
$listings_result = mysqli_query($conn, $sql_listings);

// Debug: Check if query executed
if (!$listings_result) {
    die("<p style='color:red;'>Error fetching listings: " . mysqli_error($conn) . "</p>");
}

// Debug: Ensure listings exist before HTML loads
$listings_count = mysqli_num_rows($listings_result);
if ($listings_count === 0) {
    echo "<p style='color:red;'>No listings found in the database.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Listings - Admin Panel</title>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #F4F4F4; text-align: center;">

    <header style="background: #222; padding: 15px; color: white;">
        <nav>
            <a href="admin_dashboard.php" style="color: white; text-decoration: none; font-size: 18px;">← Back to Dashboard</a>
        </nav>
    </header>

    <div style="width: 80%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 5px 15px rgba(0,0,0,0.1); margin-top: 20px;">
        <h1>Manage Listings</h1>

        <?php if (isset($_GET['deleted'])): ?>
            <p style="color: <?php echo $_GET['deleted'] === 'success' ? 'green' : 'red'; ?>;">
                <?php
                    if ($_GET['deleted'] === 'success') echo "✅ Listing deleted successfully.";
                    elseif ($_GET['deleted'] === 'fail') echo "❌ Deletion failed. Please try again.";
                    elseif ($_GET['deleted'] === 'invalid') echo "⚠️ Invalid request.";
                ?>
            </p>
        <?php endif; ?>

        <?php if ($listings_count > 0): ?>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #28a745; color: white;">
                        <th style="padding: 10px; border: 1px solid #ccc;">Ad ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Seller ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Title</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Price</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Description</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Image</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Rating</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Category</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">User ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($listing = mysqli_fetch_assoc($listings_result)): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($listing['ad_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($listing['seller_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($listing['title']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;">R<?php echo htmlspecialchars($listing['price']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($listing['description']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <img src="<?php echo htmlspecialchars($listing['image_url']); ?>" alt="Ad Image" style="width: 100px; height: auto;">
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($listing['rating']); ?> ⭐</td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($listing['category']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;"><?php echo htmlspecialchars($listing['user_id']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <form action="delete_listing.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                    <input type="hidden" name="ad_id" value="<?php echo htmlspecialchars($listing['ad_id']); ?>">
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
        <a href="admin_dashboard.php" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">← Back to Dashboard</a>
    </div>

</body>
</html>
