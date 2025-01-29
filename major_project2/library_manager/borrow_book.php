<?php
include 'db_connect.php'; // Include the connection file

// Initialize error and success message variables
$error_message = '';
$success_message = '';

// Fetch students from the admin database
$students = mysqli_query($admin_conn, "SELECT id, name FROM students");

// Fetch books from the library_management database
$books = mysqli_query($library_conn, "SELECT book_id, name FROM books");

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted values only if they exist
    $student_id = isset($_POST['student_id']) ? mysqli_real_escape_string($library_conn, $_POST['student_id']) : '';
    $book_id = isset($_POST['book_id']) ? mysqli_real_escape_string($library_conn, $_POST['book_id']) : '';
    $borrow_date = date('Y-m-d');

    // Check if the book_id is empty
    if (empty($book_id)) {
        $error_message = "Error: Please select a book!"; // Display error if no book is selected
    } else {
        // Check if the book exists in the database
        $book_check = mysqli_query($library_conn, "SELECT book_id FROM books WHERE book_id = '$book_id'");
        if (mysqli_num_rows($book_check) == 0) {
            $error_message = "Error: Book not found!"; // Display error if book not found
        } else {
            // Insert the borrow record into the borrowed_books table
            $query = "INSERT INTO borrowed_books (student_id, book_id, borrow_date) VALUES ('$student_id', '$book_id', '$borrow_date')";
            if (mysqli_query($library_conn, $query)) {
                $success_message = "Book borrowed successfully!";
                $error_message = ''; // Clear error message on success
            } else {
                $error_message = "Error: " . mysqli_error($library_conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
    <link rel="stylesheet" href="library_styles.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <h2>Borrow Book</h2>

            <!-- Display Success Message if set -->
            <?php if (!empty($success_message)): ?>
                <div class="success-message">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <!-- Display Error Message only on form submission -->
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($error_message)): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Borrow Book Form -->
            <form action="borrow_book.php" method="POST" class="book-form">
                <div class="form-group">
                    <label for="student_id">Select Student:</label>
                    <select name="student_id" id="student_id">
                        <?php while ($student = mysqli_fetch_assoc($students)): ?>
                            <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="book_id">Select Book:</label>
                    <select name="book_id" id="book_id">
                        <option value="">-- Select a Book --</option>
                        <?php while ($book = mysqli_fetch_assoc($books)): ?>
                            <option value="<?php echo $book['book_id']; ?>"><?php echo $book['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="Borrow Book">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
