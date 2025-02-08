<?php
session_start(); // Start the session at the very beginning

// Database credentials (REPLACE THESE WITH YOUR CREDENTIALS)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lasi_web";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            echo "Username and password are required.";
            exit;
        }

        $stmt = $conn->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hashed_password_from_db = $result['password'];

            if (password_verify($password, $hashed_password_from_db)) { // Verify password
                $_SESSION['username'] = $username; // Store username in session
                echo "success";
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "Username not found.";
        }
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage(); // Log this in a real app
}

$conn = null;
?>