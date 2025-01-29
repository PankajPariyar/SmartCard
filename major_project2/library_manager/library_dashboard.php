<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management Dashboard</title>
    <link rel="stylesheet" href="library_styles.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h3>Menu</h3>
            <ul>
                <li><a href="view_books.php">View All Books</a></li>
                <li><a href="add_book.php">Add New Book</a></li>
                <li><a href="student_details.php">Student Details</a></li>
                <li><a href="dues_history.php">Dues & History</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h2>Library Books</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Faculty</th>
                        <th>Copies Available</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "library_management";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT name, author, faculty, copies_available FROM books";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["name"]. "</td><td>" . $row["author"]. "</td><td>" . $row["faculty"]. "</td><td>" . $row["copies_available"]. "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No books available</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
