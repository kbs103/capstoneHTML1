<?php
session_start();
require_once 'db_connect.php'; 

if (isset($_POST['login'])) {
    // 1. Collect and sanitize input
    $user_input = trim($_POST['username']);
    $pass_input = $_POST['password'];

    // 2. Prepare the statement 
    // Even if you have 4 columns, we only SELECT the ones we need to verify the user.
    $sql = "SELECT user_id, user_name, user_password FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);

    // DEBUGGING: If prepare fails, this will tell you why (e.g., column name mismatch)
    if (!$stmt) {
        die("MySQL Prepare Error: " . $conn->error);
    }

    // 3. Bind and Execute
    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    // 4. Check if user exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // 5. Verify Password
        if (password_verify($pass_input, $row['user_password'])) {
            // Regenerate session ID for security
            session_regenerate_id(true);
            
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['user_name'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            echo "$pass_input";
            echo $row['user_password'];
            echo "Invalid username or password.";
        }
    } else {

        echo "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>