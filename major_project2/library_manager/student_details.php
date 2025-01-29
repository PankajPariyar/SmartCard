<?php
// db_connect.php

$servername = "localhost";  // Your server name
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "library_management"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check database connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Fetch all student data
$query = "SELECT * FROM admin.students";
$result = mysqli_query($conn, $query);

// Check if query executed successfully
if (!$result) {
    die("ERROR: Could not execute $query. " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<head>
    <title>Students Details</title>
    <link rel="stylesheet" href="library_styles.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <h2>Student List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Program</th>
                <th>Semester</th>
                <th>Roll No</th>
                <th>RFID ID</th>
                <th>Level</th>
                <th>Batch</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['program']; ?></td>
                <td><?php echo $row['semester']; ?></td>
                <td><?php echo $row['roll_no']; ?></td>
                <td><?php echo $row['rfid_id']; ?></td>
                <td><?php echo $row['level']; ?></td>
                <td><?php echo $row['batch']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
