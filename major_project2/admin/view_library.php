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

// SQL query to get books and their available copies
$sql = "SELECT b.book_id, b.name, b.author, b.program, b.available_copies, 
               GROUP_CONCAT(c.status SEPARATOR ', ') AS status
        FROM library_management.books b
        LEFT JOIN book_copies c ON b.book_id = c.book_id
        GROUP BY b.book_id, b.name, b.author, b.program, b.available_copies";
        
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Books</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
        <?php include 'sidebar.php'; ?> <!-- Including the sidebar -->
        <div class="main-content">
            <h2>All Books in Library</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Program</th>
                        <th>Copies Available</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["name"]. "</td>
                                    <td>" . $row["author"]. "</td>
                                    <td>" . $row["program"]. "</td>
                                    <td>" . $row["available_copies"]. "</td>
                                    <td>" . $row["status"]. "</td>
                                    <td><a href='edit_book.php?id=" . $row["book_id"] . "' class='edit-btn'>Edit</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No books available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
</body>
</html>

<?php
$conn->close();
?>
