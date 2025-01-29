<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'canteen_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available menu items
$menu_sql = "SELECT * FROM menu_items WHERE availability = 1";
$menu_result = $conn->query($menu_sql);

// Place an order
if (isset($_POST['place_order'])) {
    $rfid = $_POST['rfid'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    // Get item price
    $item_sql = "SELECT price FROM menu_items WHERE id = '$item_id'";
    $item_result = $conn->query($item_sql);
    $item = $item_result->fetch_assoc();
    $price = $item['price'];

    // Calculate total price
    $total_price = $price * $quantity;

    // Insert order into canteen_orders table
    $order_sql = "INSERT INTO canteen_orders (student_rfid, item_id, quantity, total_price) 
                  VALUES ('$rfid', '$item_id', '$quantity', '$total_price')";
    if ($conn->query($order_sql) === TRUE) {
        $success_message = "Order placed successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="canteen_styles.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <h2>Place Order</h2>

            <!-- Success or error messages -->
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Form to place an order -->
            <form method="post" action="" class="order-form">
                <div class="form-group">
                    <label for="rfid">Student RFID:</label>
                    <input type="text" id="rfid" name="rfid" required>
                </div>

                <div class="form-group">
                    <label for="item_id">Menu Item:</label>
                    <select id="item_id" name="item_id" required>
                        <option value="">Select Item</option>
                        <?php
                        if ($menu_result->num_rows > 0) {
                            while ($row = $menu_result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['name']} - Rs. {$row['price']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Place Order" name="place_order">
                </div>
            </form>
        </div>
</body>
</html>

<?php
$conn->close();
?>
