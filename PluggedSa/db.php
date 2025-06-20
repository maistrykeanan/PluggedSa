<?php
$servername = "sql305.infinityfree.com"; // From VistaPanel
$username   = "if0_39256209";
$password   = "Maistry123";
$dbname     = "if0_39256209_pluggedsa_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

if (basename($_SERVER['PHP_SELF']) === "db.php") {
    exit("Direct access to this file is not allowed.");
}
?>
