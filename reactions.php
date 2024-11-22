<?php
// Database connection class
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = ''; // Use your MySQL password here if you have one
    private $dbname = 'youtube-test'; // Replace with your actual database name
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}

// Reactions class to handle comments
class Reactions {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all reactions (comments)
    public static function getReactions() {
        $db = new Database();
        $query = "SELECT * FROM reactions ORDER BY created_at DESC"; // Assuming 'created_at' column exists
        $result = $db->conn->query($query);

        $reactions = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reactions[] = $row;
            }
        }

        return $reactions;
    }

    // Set a new reaction (comment)
    public static function setReaction($postArray) {
        $db = new Database();
        $name = $db->conn->real_escape_string($postArray['name']);
        $message = $db->conn->real_escape_string($postArray['message']);

        // Use a prepared statement to avoid SQL injection
        $stmt = $db->conn->prepare("INSERT INTO reactions (name, message, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $name, $message); // "ss" means two string parameters
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['error' => $stmt->error];
        }
    }

    // Delete a reaction (comment)
    public static function deleteReaction($commentId) {
        $db = new Database();
        // Use a prepared statement to avoid SQL injection
        $stmt = $db->conn->prepare("DELETE FROM reactions WHERE id = ?");
        $stmt->bind_param("i", $commentId); // "i" means an integer parameter
        return $stmt->execute();
    }
}
?>
