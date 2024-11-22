<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MeTube</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
            padding: 40px;
            text-align: center;
        }

        h1 {
            font-size: 3.5rem;
            color: #2c3e50;
            margin-top: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .welcome-message {
            font-size: 1.6rem;
            color: #3498db;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .description {
            margin-top: 50px;
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 900px;
            margin: 50px auto;
        }

        .description h2 {
            font-size: 2.2rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .description ul {
            list-style-type: none;
            padding-left: 0;
            text-align: left;
            margin-top: 20px;
        }

        .description ul li {
            font-size: 1.1rem;
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .description a {
            color: #99e7ff;
            text-decoration: none;
            font-weight: 600;
        }

        footer {
            margin-top: 70px;
            font-size: 1rem;
            color: #8b8b8b;
        }

        .footer-container {
            margin-top: 70px;
            text-align: center;
        }

        /* Button style */
        .btn {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            font-size: 1.1rem;
            padding: 14px 25px;
            margin-top: 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .description {
                padding: 30px;
                max-width: 95%;
            }

            .btn {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <h1>Welcome to MeTube</h1>
    <p class="welcome-message">Hello, <?php echo htmlspecialchars($username); ?>! You are logged in.</p>

    <div class="description">
        <h2>What you can do on MeTube:</h2>
        <ul>
            <li><strong>Watch videos:</strong> Explore and watch your favorite videos directly on MeTube. Access a wide range of content at your fingertips.</li>
            <li><strong>Leave comments:</strong> Share your thoughts with others! Visit the <a href="index.php">comment section</a> to engage in meaningful discussions.</li>
            <li><strong>Manage your profile:</strong> Update your profile settings and preferences anytime you like. Personalize your MeTube experience.</li>
            <li><strong>Log out:</strong> When you're done, simply log out to secure your account and protect your privacy.</li>
        </ul>
        <a href="index.php" class="btn">Go to Comment Section</a>
    </div>

    <div class="footer-container">
        <footer>
            <p>&copy; 2024 MeTube. All Rights Reserved.</p>
            <p><a href="login.php">Go to Login Page</a></p> <!-- Link to the login page -->
        </footer>
    </div>

</body>

</html>

