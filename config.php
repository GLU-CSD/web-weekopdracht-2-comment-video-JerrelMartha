<?php
// Database configuration
$host = 'localhost';  // Database host (e.g., 'localhost' for local development)
$username = 'root';    // Database username
$password = '';        // Database password (empty for XAMPP by default)
$dbname = 'youtube-test';    // The database name

// Create a new PDO instance for database connection
try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
