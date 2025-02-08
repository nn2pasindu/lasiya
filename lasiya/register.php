<?php
    // Database credentials
    $servername = "localhost"; // Your server name
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "lasi_web"; // Your database name
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            // Basic input validation (improve this!)
            if (empty($username) || empty($password)) {
                echo "Username and password are required.";
                exit;
            }
    
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            // Prepared statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
    
    
            $stmt->execute();
            echo "success";
    
        }
    
    } catch(PDOException $e) {
        // Handle errors (log them in a real application)
        echo "Error: " . $e->getMessage();
    }
    
    $conn = null; // Close the connection
    ?>