<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

$username = $_SESSION['username'];

// Include configuration and reactions logic
include_once("config.php");
include_once("reactions.php");

// Retrieve reactions from the database
$getReactions = Reactions::getReactions();

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    $postArray = [
        'name' => $name,
        'message' => $message,
    ];

    $setReaction = Reactions::setReaction(postArray: $postArray);

    if (isset($setReaction['error']) && $setReaction['error'] != '') {
        echo json_encode(['status' => 'error', 'message' => $setReaction['error']]);
        exit;
    } else {
        echo json_encode(['status' => 'success', 'name' => $name, 'message' => $message]);
        exit;
    }
}

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $password = $_POST['password'];
    $commentId = $_POST['comment_id'];

    if ($password === '1111') {
        $deleteReaction = Reactions::deleteReaction($commentId);
        if ($deleteReaction) {
            echo "<p style='color: green;'>Comment successfully deleted!</p>";
        } else {
            echo "<p style='color: red;'>Error: Comment could not be deleted.</p>";
        }
    } else {
        echo "<p style='color: red;'>Incorrect password!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Remake</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        h2, h3 {
            color: #2c3e50;
        }

        /* YouTube iframe */
        iframe {
            display: block;
            margin: 0 auto 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        /* Button to resize iframe */
        .resize-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 20px auto;
        }

        .resize-btn:hover {
            background-color: #2980b9;
        }

        /* Comment form */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .comment {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .comment strong {
            font-size: 18px;
            color: #2c3e50;
        }

        .comment p {
            margin-top: 10px;
            font-size: 16px;
            color: #7f8c8d;
        }

        /* Delete comment form */
        .comment form {
            margin-top: 15px;
            display: flex;
            align-items: center;
        }

        .comment form input[type="password"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
            font-size: 14px;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

<a href="home.php">Go to Homepage</a>


<iframe id="videoFrame" width="560" height="315" src="https://www.youtube.com/embed/_S7dhK_DtEo?si=0_8d2qLYqa7sQJkW" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

<!-- Resize Button -->
<button class="resize-btn" onclick="toggleIframeSize()">Enlarge Video</button>

<h2>Comments</h2>

<!-- Comment Form -->
<form id="commentForm" action="" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" required></textarea><br>

    <button type="submit" name="submit">Post Comment</button>
</form>

<h3>Comments</h3>
<div id="commentsSection">
    <?php
    // Display comments
    if (!empty($getReactions)) {
        foreach ($getReactions as $reaction) {
            $commentId = $reaction['id'];
            $name = htmlspecialchars($reaction['name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8');
            $message = htmlspecialchars($reaction['message'] ?? 'No message', ENT_QUOTES, 'UTF-8');

            echo "<div class='comment' id='comment_$commentId'>";
            echo "<strong>$name</strong><br>";
            echo "<p>$message</p>";

            // Delete form
            echo "<form action='' method='POST'>";
            echo "<input type='hidden' name='comment_id' value='$commentId'>";
            echo "<input type='password' name='password' placeholder='Password' required>";
            echo "<button type='submit' name='delete'>Remove Comment</button>";
            echo "</form>";

            echo "</div>";
        }
    } else {
        echo "<p>There are no comments yet.</p>";
    }
    ?>
</div>

<footer>
    <p>&copy; 2024 MeTube</p>
</footer>

<script>
    function toggleIframeSize() {
        var iframe = document.getElementById('videoFrame');
        var btn = document.querySelector('.resize-btn');

        // Check current iframe size
        if (iframe.width === '560') {
            // Resize iframe to larger size
            iframe.width = '1200';
            iframe.height = '600';
            btn.innerHTML = 'Resize'; // Change button text
        } else {
            // Restore iframe to original size
            iframe.width = '560';
            iframe.height = '315';
            btn.innerHTML = 'Enlarge Video'; // Change button text
        }
    }

    document.getElementById('commentForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        var name = document.getElementById('name').value;
        var message = document.getElementById('message').value;

        var formData = new FormData();
        formData.append('name', name);
        formData.append('message', message);
        formData.append('submit', true);

        fetch('index.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Dynamically add the new comment to the comments section
                var newComment = document.createElement('div');
                newComment.classList.add('comment');
                newComment.innerHTML = `<strong>${data.name}</strong><br><p>${data.message}</p>`;
                document.getElementById('commentsSection').appendChild(newComment);

                // Clear the form fields
                document.getElementById('name').value = '';
                document.getElementById('message').value = '';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>
