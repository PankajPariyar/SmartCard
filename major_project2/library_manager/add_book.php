<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $author = $_POST['author'];
    $program = $_POST['program'];
    $genre = $_POST['genre'];
    $isbn = $_POST['isbn'];
    $publication_year = $_POST['publication_year'];
    $publisher = $_POST['publisher'];
    $cost = $_POST['cost'];
    $copies_available = $_POST['totalCopies'];

    // Insert book details using prepared statement
    $stmt = $conn->prepare("INSERT INTO books (name, author, program, genre, isbn, publication_year, publisher, cost, total_copies, available_copies) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssiisii", $name, $author, $program, $genre, $isbn, $publication_year, $publisher, $cost, $copies_available, $copies_available);

    if ($stmt->execute()) {
        $book_id = $stmt->insert_id; // Get the last inserted book ID

        // Insert copies
        for ($i = 1; $i <= $copies_available; $i++) {
            // Generate a unique copy ID with timestamp to ensure uniqueness
            $copy_id = $isbn . '-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . time(); // Append timestamp
            $copy_stmt = $conn->prepare("INSERT INTO book_copies (book_id, copy_id, status) VALUES (?, ?, 'available')");
            $copy_stmt->bind_param("is", $book_id, $copy_id);
            
            if (!$copy_stmt->execute()) {
                $error_message = "Error inserting copy ID: " . $copy_stmt->error;
            }
        }
        if (!$error_message) {
            $success_message = "New book and copies added successfully!";
        }
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    // Close the statements
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link rel="stylesheet" href="library_styles.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <h2>Add New Book</h2>
            <form action="add_book.php" method="POST" class="book-form">
                <!-- Display success or error message here -->
                <?php if ($success_message): ?>
                    <p class="success-message"><?php echo $success_message; ?></p>
                <?php elseif ($error_message): ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                <?php endif; ?>

                <div class="form-group">
                    <label for="name">Book Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter the name of book" required>
                </div>

                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" placeholder="Enter the author of book" required>
                </div>

                <div class="form-group">
                    <label for="program">Program:</label>
                    <select id="program" name="program">
                        <option value="Computer Engineering">Computer Engineering</option>
                        <option value="Electrical Engineering">Electrical Engineering</option>
                        <option value="E & E Engineering">E & E Engineering</option>
                        <option value="Civil Engineering">Civil Engineering</option>
                        <option value="HA">HA</option>
                        <option value="Lab Technician">Lab Technician</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="genre">Genre:</label>
                    <input type="text" id="genre" name="genre" placeholder="Enter the genre of book">
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" placeholder="Enter the ISBN number of book" required>
                </div>

                <div class="form-group">
                    <label for="publication_year">Publication Year:</label>
                    <input type="number" id="publication_year" name="publication_year" placeholder="Enter the publication year of book" required>
                </div>

                <div class="form-group">
                    <label for="publisher">Publisher:</label>
                    <input type="text" id="publisher" name="publisher" placeholder="Enter the publisher of book" required>
                </div>

                <div class="form-group">
                    <label for="cost">Cost:</label>
                    <input type="number" id="cost" name="cost" required placeholder="Enter the cost of book">
                </div>

                <div class="form-group">
                    <label for="totalCopies">Total Copies:</label>
                    <input type="number" id="totalCopies" name="totalCopies" min="1" placeholder="Enter the available copies of book" required><br>
                </div>
                
                <div class="form-group">
                    <input type="submit" value="Add Book">
                </div>
            </form>
        </div>
</body>
</html>
