<?php
include 'db_connect.php';

// Check if student ID is passed
if (isset($_POST['student_id'])) {
    // Get student ID and borrowed book information
    $student_id = $_POST['student_id'];

    // Fetch the borrowed book details from the library database
    $borrowed_books_query = "SELECT * FROM borrowed_books WHERE student_id = '$student_id' AND status = 'borrowed' LIMIT 1";
    $borrowed_books_result = mysqli_query($library_conn, $borrowed_books_query);

    if (mysqli_num_rows($borrowed_books_result) > 0) {
        $borrowed_book = mysqli_fetch_assoc($borrowed_books_result);
        $borrowed_id = $borrowed_book['id'];  // Get the borrowed book ID
        $return_date = date('Y-m-d');  // Current date as return date

        // Update the borrowed book record in the library_management database
        $update_query = "UPDATE borrowed_books SET return_date = '$return_date', status = 'returned' WHERE id = '$borrowed_id'";
        
        if (mysqli_query($library_conn, $update_query)) {
            echo "Book returned successfully!";
        } else {
            echo "Error: " . mysqli_error($library_conn);
        }
    } else {
        echo "No borrowed books found for this student.";
    }
} else {
    echo "Error: Student ID is missing.";
}
?>
