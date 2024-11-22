<?php
// Simple signup logic

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Simple validation
    if (!empty($username) && !empty($password)) {
        $userData = $username . ',' . password_hash($password, PASSWORD_DEFAULT) . "\n";
        
        // Store the data in a file (users.txt)
        file_put_contents('users.txt', $userData, FILE_APPEND);
        echo "<p>Account created successfully!</p>";
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - MeTube</title>
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

<h2>Sign Up</h2>
<form action="signup.php" method="POST">
    <input type="text" name="username" placeholder="Enter username" required><br>
    <input type="password" name="password" placeholder="Enter password" required><br>
    <button type="submit">Sign Up</button>
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>
