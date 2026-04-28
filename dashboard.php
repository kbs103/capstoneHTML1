<?php
include 'auth_check.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>You are successfully logged in.</p>
    
    <a href="logout.php" style="color: red;">Log Out</a>
</body>
</html>