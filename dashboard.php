<?php
include 'auth_check.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Grocery Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f8f4;
        }

        header {
            background-color: #2e7d32;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 {
            margin: 0;
        }

        .logout {
            color: #fff;
            text-decoration: none;
            background-color: #c62828;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .container {
            padding: 30px;
        }

        .welcome {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2e7d32;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #388e3c;
        }

        .card p {
            color: #555;
        }

        .emoji {
            font-size: 40px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<header>
    <h2>🛒 Grocery Dashboard</h2>
    <a href="logout.php" class="logout">Log Out</a>
</header>

<div class="container">
    <div class="welcome">
        Hello, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋
    </div>

    <div class="cards">
        <div class="card">
            <div class="emoji">🥦</div>
            <h3>Fresh Produce</h3>
            <p>View fruits and vegetables</p>
        </div>

        <div class="card">
            <div class="emoji">🥩</div>
            <h3>Meat & Seafood</h3>
            <p>Check available meats</p>
        </div>

        <div class="card">
            <div class="emoji">🥛</div>
            <h3>Dairy Products</h3>
            <p>Milk, cheese, and more</p>
        </div>

        <div class="card">
            <div class="emoji">🛍️</div>
            <h3>Your Orders</h3>
            <p>View your purchases</p>
        </div>
    </div>
</div>

</body>
</html>