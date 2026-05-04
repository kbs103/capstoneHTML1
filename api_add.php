<?php
require_once 'db_connect.php';

// Log everything to a text file to see what the Arduino is doing
file_put_contents('debug_log.txt', "Full Body: " . file_get_contents('php://input') . "\n", FILE_APPEND);

// We are only checking if the essential data exists now
if (isset($_POST['item_type'])) {
    $type  = $_POST['item_type'];
    $brand = $_POST['item_brand'];
    $price = (float)$_POST['item_price'];
    $qty   = (int)$_POST['item_qty'];

    // Updated to match image_d21a42.png column names
    $stmt = $conn->prepare("INSERT INTO inventory (item_Type, item_Brand, item_Price, item_Qty) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $type, $brand, $price, $qty);
    
    if ($stmt->execute()) {
        echo "SUCCESS_ADDED";
    } else {
        echo "DATABASE_ERROR: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "ERROR: No data received in POST. Check Content-Type and Newline.";
}
$conn->close();
?>