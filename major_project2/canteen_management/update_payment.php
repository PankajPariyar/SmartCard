<?php
// Include the database connection
include('db_connection.php');

// Check if order_id is passed via URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Update the order status to 'Paid'
    $query = "UPDATE canteen_orders SET order_status = 'Paid' WHERE order_id = $order_id";

    if (mysqli_query($conn, $query)) {
        // Redirect back to manage orders page after updating
        header("Location: manage_orders.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Error: Order ID not found.";
}
?>
