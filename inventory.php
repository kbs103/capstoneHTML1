<?php
include 'auth_check.php';
require_once 'db_connect.php';
require_login();

// --- START OF ACTIONS ---
// This part runs before the HTML is rendered

// 1. Handle Add Item
if (isset($_POST['add_item'])) {
    $name = $_POST['item_name'];
    $qty = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];

    $stmt = $conn->prepare("INSERT INTO inventory (item_name, quantity, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $name, $qty, $price);
    $stmt->execute();
    $stmt->close();
    
    // Redirect to same page to prevent form resubmission on refresh
    header("Location: inventory.php");
    exit();
}

// 2. Handle Update Quantity
if (isset($_POST['update_qty'])) {
    $id = (int)$_POST['id'];
    $new_qty = (int)$_POST['new_qty'];

    $stmt = $conn->prepare("UPDATE inventory SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_qty, $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: inventory.php");
    exit();
}
// --- END OF ACTIONS ---

// Fetch current inventory for the grid
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Manager</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: auto; }
        
        /* Form Styling */
        .add-form { background: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .add-form input { padding: 10px; margin-right: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn-add { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }

        /* Grid Styling */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            text-align: center;
            border-top: 5px solid #3498db;
        }
        .card h3 { margin: 10px 0; color: #333; }
        .stock-tag { font-weight: bold; color: #7f8c8d; display: block; margin-bottom: 15px; }
        
        .update-box { display: flex; justify-content: center; gap: 5px; }
        .update-box input { width: 60px; text-align: center; }
        .btn-update { background: #3498db; color: white; border: none; padding: 5px; border-radius: 3px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h1>Inventory Control</h1>
    <p><a href="dashboard.php">← Return to Dashboard</a></p>

    <div class="add-form">
        <h3>Register New Stock</h3>
        <form action="inventory.php" method="POST">
            <input type="text" name="item_name" placeholder="Item Name" required>
            <input type="number" name="quantity" placeholder="Initial Qty" required>
            <input type="number" step="0.01" name="price" placeholder="Price ($)" required>
            <button type="submit" name="add_item" class="btn-add">Add to Grid</button>
        </form>
    </div>

    <div class="grid-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
                    <span class="stock-tag">Unit Price: $<?php echo number_format($row['price'], 2); ?></span>