<?php
// student_dues.php
include 'db_connect.php';

// Fetch the first student (or specify any particular student ID) from the admin database
$student_result = mysqli_query($admin_conn, "SELECT * FROM students LIMIT 1");

if ($student_result->num_rows > 0) {
    $student = mysqli_fetch_assoc($student_result);

    // Fetch transaction history from library_management database
    $transactions = mysqli_query($library_conn, "SELECT * FROM transactions WHERE student_id = {$student['id']}");

    // Fetch dues from library_management database
    $dues_result = mysqli_query($library_conn, "SELECT * FROM dues WHERE student_id = {$student['id']} AND status = 'unpaid'");
    $total_due = 0;

    // Calculate the total dues for the student
    while ($due = mysqli_fetch_assoc($dues_result)) {
        $total_due += $due['amount'];
    }
} else {
    echo "No student found in the system.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dues</title>
    <link rel="stylesheet" href="library_styles.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <h2>Student Dues</h2>

            <?php if (isset($student)): ?>
                <h3><?php echo $student['name']; ?> (Student ID: <?php echo $student['id']; ?>)</h3>
                <p>Balance: $<?php echo number_format($student['card_balance'], 2); ?></p>

                <h4>Transaction History</h4>
                <table>
                    <tr>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                    <?php while ($transaction = mysqli_fetch_assoc($transactions)): ?>
                        <tr>
                            <td><?php echo ucfirst($transaction['action']); ?></td>
                            <td><?php echo $transaction['date']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>

                <h4>Total Dues: $<?php echo number_format($total_due, 2); ?></h4>
                <form action="process_payment.php" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                        <input type="submit" value="Pay Dues">
                    </div>
                </form>

                <!-- Add buttons to perform various actions -->
                <h4>Library Management Actions</h4>
                <div class="library-actions">
                    <form action="borrow_book.php" method="POST" style="display:inline-block;">
                        <div class="form-group">
                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                            <input type="submit" value="Borrow Book">
                        </div>
                    </form>

                    <form action="student_history.php" method="GET" style="display:inline-block;">
                        <div class="form-group">
                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                            <input type="submit" value="View Borrowing History">
                        </div>
                    </form>

                    <form action="return_book.php" method="POST" style="display:inline-block;">
                        <div class="form-group">
                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                               <!-- Return Book form -->
    <form action="return_book.php" method="POST" style="display:inline-block;">
        <div class="form-group">
            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
            <input type="submit" value="Return Book">
        </div>
    </form>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <p>No student details found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
