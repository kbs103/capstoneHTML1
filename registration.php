<?php
require_once 'db_connect.php'; // Ensure this file no longer has $conn->close()

if (isset($_POST['register'])) {
    // 1. Collect and sanitize
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    // 2. Hash the password (CRITICAL for security)
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // 3. Prepare the SQL for your 4 columns
    // I'm assuming: id (auto-increment), username, password
    $sql = "INSERT INTO users (user_name, user_password) VALUES (?, ?)";
    
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // "sss" means three strings
        $stmt->bind_param("ss", $user, $hashed_pass);

        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.html'>Login here</a>";
        } else {
            // Check for duplicate usernames
            if ($conn->errno === 1062) {
                echo "Error: Username already exists.";
            } else {
                echo "Execution failed: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
}

$conn->close();
?>