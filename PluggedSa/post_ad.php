<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'seller') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    
    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_url = $target_file;

        $sql = "INSERT INTO ads (seller_id, title, price, description, image_url, category) 
                VALUES ('$seller_id', '$title', '$price', '$description', '$image_url', '$category')";

        if (mysqli_query($conn, $sql)) {
            header("Location: seller_home.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Post an Ad</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="chat.php">Chat</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Post a New Ad</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Product Title" required>
            <input type="number" name="price" placeholder="Price" required>
            <textarea name="description" placeholder="Product Description" required></textarea>
            <input type="file" name="image" accept="image/*" required>
            <select name="category">
                <option value="Electronics">Electronics</option>
                <option value="Furniture">Furniture</option>
                <option value="Clothing">Clothing</option>
                <option value="Automobiles">Automobiles</option>
            </select>
            <button type="submit">Post Ad</button>
        </form>
    </main>
</body>
</html>
