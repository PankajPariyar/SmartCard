<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT students.name AS student_name, students.faculty, students.semester, students.roll_no, 
        books.name AS book_name, borrows.borrow_date, borrows.return_date, borrows.due_amount 
        FROM students
        LEFT JOIN borrows ON students.id = borrows.student_id
        LEFT JOIN books ON borrows.book_id = books.id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dues & History</title>
    <link rel="stylesheet" href="library_styles.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?> <!-- Including the sidebar -->
        <div class="main-content">
            <h2>Dues & Book History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Faculty</th>
                        <th>Semester</th>
                        <th>Roll No</th>
                        <th>Book Borrowed</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Due Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["student_name"]. "</td><td>" . $row["faculty"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["roll_no"]. "</td><td>" . $row["book_name"]. "</td><td>" . $row["borrow_date"]. "</td><td>" . $row["return_date"]. "</td><td>" . $row["due_amount"]. "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No dues or history available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
