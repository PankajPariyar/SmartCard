<?php
include 'db_connect.php'; // Include the database connection file

// Initialize variables for error messages
$error_message = '';
$student = null;
$history_result = null;

// Check if student_id is passed in the URL
if (isset($_GET['student_id'])) {
    $student_id = intval($_GET['student_id']); // Sanitize input to ensure it's an integer

    // Fetch student details from the admin database
    $student_query = "SELECT * FROM students WHERE id = $student_id";
    $student_result = mysqli_query($admin_conn, $student_query);

    if ($student_result && mysqli_num_rows($student_result) > 0) {
        $student = mysqli_fetch_assoc($student_result);

        // Fetch borrowed books history from the library_management database
        $history_query = "SELECT bb.id AS borrowed_id, b.name AS book_name, bb.borrow_date, bb.return_date,
                                 CASE 
                                     WHEN bb.return_date IS NULL THEN 'Not returned'
                                     ELSE 'Returned'
                                 END AS return_status
                          FROM borrowed_books bb
                          JOIN books b ON bb.book_id = b.book_id
                          WHERE bb.student_id = $student_id";
        $history_result = mysqli_query($library_conn, $history_query);
    } else {
        $error_message = "Error: No student found with ID $student_id.";
    }
} else {
    $error_message = "Error: No student selected.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student History</title>
    <link rel="stylesheet" href="library_styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // AJAX function to handle book return
        function returnBook(borrowedId, studentId) {
            $.ajax({
                url: 'return_book.php',  // The PHP script to handle the update
                type: 'POST',
                data: {
                    borrowed_id: borrowedId,
                    student_id: studentId
                },
                success: function(response) {
                    // Update the return status on the page dynamically
                    if (response === "success") {
                        // Update the status text to "Book returned"
                        $('#status-' + borrowedId).text("Returned");
                        $('#action-' + borrowedId).html("<span>Book already returned</span>");
                    } else {
                        alert("Error: " + response);
                    }
                },
                error: function() {
                    alert("An error occurred. Please try again.");
                }
            });
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <h2>Borrowing History</h2>

            <!-- Display error message if set -->
            <?php if ($error_message): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Display student details if available -->
            <?php if ($student): ?>
                <h3>Student Name: <?php echo htmlspecialchars($student['name']); ?></h3>
                <h4>Student ID: <?php echo htmlspecialchars($student['id']); ?></h4>
                
                <!-- Display borrowing history if available -->
                <?php if ($history_result && mysqli_num_rows($history_result) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Book Name</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($history_result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['borrow_date']); ?></td>
                                    <td><?php echo $row['return_date'] ? htmlspecialchars($row['return_date']) : 'Not returned'; ?></td>
                                    <td id="status-<?php echo $row['borrowed_id']; ?>"><?php echo htmlspecialchars($row['return_status']); ?></td>
                                    <td id="action-<?php echo $row['borrowed_id']; ?>">
                                        <?php if ($row['return_status'] == 'Not returned'): ?>
                                            <!-- Return Book button -->
                                            <button onclick="returnBook(<?php echo $row['borrowed_id']; ?>, <?php echo $student['id']; ?>)">Return Book</button>
                                        <?php else: ?>
                                            <span>Book already returned</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No borrowing history found for this student.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
