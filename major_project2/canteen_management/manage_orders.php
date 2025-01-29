<?php
// Include the database connection
include('db_connection.php');

// Initialize variables
$student_rfid = '';  // To retain the entered RFID value in the input field

// Fetch the RFID from the form or RFID scanner input
if (isset($_POST['rfid'])) {
    $student_rfid = $_POST['rfid'];  // Assuming the RFID is submitted via POST
    $query = "SELECT * FROM canteen_orders WHERE student_rfid = '$student_rfid' AND status = 'Pending'";
    $result = mysqli_query($conn, $query);
} else {
    // If no RFID is scanned yet, show all orders
    $query = "SELECT * FROM canteen_orders";
    $result = mysqli_query($conn, $query);
}

// Check for query errors
if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="canteen_styles.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <h2>Canteen Order Management</h2>

        <!-- RFID Search Form -->
        <form action="manage_orders.php" method="POST" class="form-group">
            <label for="rfid">Enter RFID for Payment:</label>
            <input type="text" name="rfid" id="rfid" placeholder="Scan or enter RFID" value="<?php echo htmlspecialchars($student_rfid); ?>" required>
            <button type="submit" class="box">Search Order</button>
        </form>

        <!-- Orders Table -->
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Student RFID</th>
                    <th>Item ID</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
                
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo $row['student_rfid']; ?></td>
                        <td><?php echo $row['item_id']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><?php echo isset($row['status']) ? $row['status'] : 'Unknown'; ?></td>
                        <td>
                            <!-- Button to mark as paid -->
                            <?php if (isset($row['status']) && $row['status'] == 'Pending') { ?>
                                <a href="update_payment.php?order_id=<?php echo $row['order_id']; ?>" class="btn">Mark as Paid</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No orders found.</p>
        <?php } ?>
    </div>
</body>
</html>
