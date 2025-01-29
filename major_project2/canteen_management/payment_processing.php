<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'canteen_system');
$admin_conn = new mysqli('localhost', 'root', '', 'Admin');  // Admin database connection

// Check connection
if ($conn->connect_error || $admin_conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process payment
if (isset($_POST['pay_order'])) {
    $order_id = $_POST['order_id'];

    // Get order details (student RFID and total price)
    $order_sql = "SELECT student_rfid, total_price FROM canteen_orders WHERE order_id = '$order_id' AND order_status = 'pending'";
    $order_result = $conn->query($order_sql);

    if ($order_result->num_rows > 0) {
        $order = $order_result->fetch_assoc();
        $rfid = $order['student_rfid'];
        $total_price = $order['total_price'];

        // Get student's current balance from the Admin database
        $balance_sql = "SELECT balance FROM students WHERE RFID = '$rfid'";
        $balance_result = $admin_conn->query($balance_sql);
        if ($balance_result->num_rows > 0) {
            $balance = $balance_result->fetch_assoc()['balance'];

            // Check if student has enough balance
            if ($balance >= $total_price) {
                // Deduct the amount from student's balance
                $new_balance = $balance - $total_price;
                $update_balance_sql = "UPDATE students SET balance = '$new_balance' WHERE RFID = '$rfid'";
                $admin_conn->query($update_balance_sql);

                // Mark the order as paid
                $update_order_sql = "UPDATE canteen_orders SET order_status = 'paid' WHERE order_id = '$order_id'";
                if ($conn->query($update_order_sql) === TRUE) {
                    echo "Payment successful! Order has been marked as paid.";
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Insufficient balance!";
            }
        } else {
            echo "Student not found!";
        }
    } else {
        echo "Order not found or already paid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processing</title>
    <link rel="stylesheet" href="canteen_styles.css">
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Including the sidebar -->

    <div class="main-content">
        <h2>Payment Processing</h2>
        
        <!-- Form to process payment -->
        <form method="post" action="">

        <div class="form-group">
            <label>Order ID:</label>
            <input type="text" name="order_id" required><br>
            </div>

            <div class="form-group">
            <button type="submit" name="pay_order">Process Payment</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
$admin_conn->close();
?>
