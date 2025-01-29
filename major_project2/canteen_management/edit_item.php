<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'canteen_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error_message = '';
$success_message = '';
$item = null;

// Check if ID is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the menu item details
    $sql = "SELECT * FROM menu_items WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        $error_message = 'Item not found.';
    }
} else {
    $error_message = 'Invalid request. No item ID provided.';
}

// Handle update
if (isset($_POST['update_item'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $availability = isset($_POST['availability']) ? 1 : 0;

    // Update query
    $update_sql = "UPDATE menu_items SET name = '$name', price = '$price', availability = '$availability' WHERE id = '$id'";

    if ($conn->query($update_sql) === TRUE) {
        $success_message = 'Item updated successfully!';
        // Refresh the details
        $sql = "SELECT * FROM menu_items WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $item = $result->fetch_assoc();
        }
    } else {
        $error_message = 'Error updating item: ' . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="canteen_styles.css">
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Including the sidebar -->

    <div class="main-content">
        <h2>Edit Menu Item</h2>

        <?php if ($error_message): ?>
            <div class="error-msg"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-msg"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($item): ?>

             <!-- Back Button -->
             <a href="menu_management.php"
            style="display: inline-block; margin-bottom: 15px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px;">Back to Menu</a>
            
            <!-- Form to edit menu item -->
            <form method="post" action="">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

                <div class="form-group">
                <label for="name">Item Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $item['name']; ?>" required>
        </div>

                
                <div class="form-group">
                    <label for="price">Price:</label>
                <input type="number" step="0.01" name="price" id="price" value="<?php echo $item['price']; ?>" required>
        </div>

                
                <div class="form-group">
                    <label for="availability">Available:</label>
                <input type="checkbox" name="availability" id="availability" <?php echo $item['availability'] ? 'checked' : ''; ?>>
        </div>

                <div class="form-group">
                <button type="submit" name="update_item" class="box">Update Item</button>
        </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
