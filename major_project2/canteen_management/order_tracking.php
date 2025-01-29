<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'canteen_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders along with item details
$order_sql = "
    SELECT 
        o.order_id, 
        o.student_rfid, 
        o.quantity, 
        m.name AS item_name, 
        m.price, 
        o.quantity * m.price AS total_price
    FROM 
        canteen_orders o
    JOIN 
        menu_items m
    ON 
        o.item_id = m.id";

$order_result = $conn->query($order_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <link rel="stylesheet" href="canteen_styles.css">
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Including the sidebar -->

    <div class="main-content">
        <h2>Order Tracking</h2>
        
        <!-- Order table -->
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Student RFID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price per Item</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($order_result && $order_result->num_rows > 0) {
                    while ($row = $order_result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['order_id']}</td>
                                <td>{$row['student_rfid']}</td>
                                <td>{$row['item_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['total_price']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
