<?php
session_start(); // Start session to store user info

// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Check if the user exists in the 'users.txt' file
    $users = file('users.txt', FILE_IGNORE_NEW_LINES);
    $isAuthenticated = false;

    foreach ($users as $user) {
        list($storedUsername, $storedPasswordHash) = explode(',', $user);

        // Verify if the username and password match
        if ($storedUsername === $username && password_verify($password, $storedPasswordHash)) {
            $_SESSION['username'] = $username;
            header('Location: home.php'); // Redirect to homepage
            exit;
        }
    }

    echo "<p style='color: red;'>Invalid credentials. Please try again.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MeTube</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            display: inline-block;
        }

        input[type="text"], input[type="password"] {
            width: 200px;
            padding: 10px;
            margin: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<h2>Login</h2>
<form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Enter username" required><br>
    <input type="password" name="password" placeholder="Enter password" required><br>
    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="signup.php">Sign up here</a></p>

</body>
</html>
