<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'canteen_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize messages
$success_message = '';
$error_message = '';

// Add a new menu item
if (isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $availability = isset($_POST['availability']) ? 1 : 0;

    $sql = "INSERT INTO menu_items (name, price, availability) VALUES ('$name', '$price', '$availability')";
    if ($conn->query($sql) === TRUE) {
        $success_message = 'Menu item added successfully!';
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Update a menu item
if (isset($_POST['update_item'])) {
    $id = $_POST['item_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $availability = isset($_POST['availability']) ? 1 : 0;

    $update_sql = "UPDATE menu_items SET name = '$name', price = '$price', availability = '$availability' WHERE id = '$id'";
    if ($conn->query($update_sql) === TRUE) {
        $success_message = 'Menu item updated successfully!';
    } else {
        $error_message = "Error updating item: " . $conn->error;
    }
}

// Delete a menu item
if (isset($_POST['delete_item'])) {
    $delete_id = $_POST['delete_id'];

    $delete_sql = "DELETE FROM menu_items WHERE id = '$delete_id'";
    if ($conn->query($delete_sql) === TRUE) {
        $success_message = 'Menu item deleted successfully!';
    } else {
        $error_message = "Error deleting item: " . $conn->error;
    }
}

// Fetch all menu items
$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === FALSE) {
    die("Error: Could not retrieve menu items - " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
    <link rel="stylesheet" href="canteen_styles.css">
    <script>
        function showEditForm(id) {
            const editForm = document.getElementById('edit-form-' + id);
            editForm.style.display = 'block';
        }

        function hideEditForm(id) {
            const editForm = document.getElementById('edit-form-' + id);
            editForm.style.display = 'none';
        }
    </script>
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Sidebar -->

    <div class="main-content">
        <h2>Menu Management</h2>

        <!-- Success and Error Messages -->
        <?php if ($success_message): ?>
            <div class="success-msg"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="error-msg"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Add New Item -->
        <button onclick="document.getElementById('add-item-modal').style.display='block'" class="box">Add New Item</button>
        <div id="add-item-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('add-item-modal').style.display='none'">&times;</span>
                <h3>Add New Menu Item</h3>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="name">Item Name:</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" step="0.01" name="price" id="price" required>
                    </div>
                    <div class="form-group">
                        <label for="availability">Available:</label>
                        <input type="checkbox" name="availability" id="availability">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="add_item" class="box">Add Item</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menu Items -->
        <h3>Menu Items</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $serial_number = 1;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $serial_number++; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['availability'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <!-- Edit -->
                                <button onclick="showEditForm(<?php echo $row['id']; ?>)" class="box">Edit</button>
                                <div id="edit-form-<?php echo $row['id']; ?>" class="modal" style="display: none;">
                                    <div class="modal-content">
                                        <span class="close" onclick="hideEditForm(<?php echo $row['id']; ?>)">&times;</span>
                                        <h3>Edit Item</h3>
                                        <form method="post" action="">
                                            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                            <div class="form-group">
                                                <label for="name">Item Name:</label>
                                                <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Price:</label>
                                                <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="availability">Available:</label>
                                                <input type="checkbox" name="availability" <?php echo $row['availability'] ? 'checked' : ''; ?>>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="update_item" class="box">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Delete -->
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_item" class="box" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>No items found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
