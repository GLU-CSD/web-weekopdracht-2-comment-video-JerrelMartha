<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

echo "<h2>Welcome, " . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . "!</h2>";
echo "<p><a href='logout.php'>Logout</a></p>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome to the website!</h2>
</body>
</html>
