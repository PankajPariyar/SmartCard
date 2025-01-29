<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "<p class='error-message'>No book found with this ID.</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $faculty = $_POST['faculty'];
    $copies_available = $_POST['copies_available'];

    $sql = "UPDATE books SET name='$name', author='$author', faculty='$faculty', copies_available=$copies_available WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-message'>Book details updated successfully!</p>";
    } else {
        echo "<p class='error-message'>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="library_styles.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'sidebar.php'; ?> <!-- Including the sidebar -->
        <div class="main-content">
            <h2>Edit Book</h2>
            <?php if (isset($book)): ?>
            <form action="edit_book.php?id=<?php echo $book['id']; ?>" method="POST" class="book-form">
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                <div class="form-group">
                    <label for="name">Book Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $book['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" value="<?php echo $book['author']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="faculty">Faculty:</label>
                    <input type="text" id="faculty" name="faculty" value="<?php echo $book['faculty']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="copies_available">Copies Available:</label>
                    <input type="number" id="copies_available" name="copies_available" value="<?php echo $book['copies_available']; ?>" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Update Book">
                </div>
            </form>
            <?php else: ?>
            <p class="error-message">Book not found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
