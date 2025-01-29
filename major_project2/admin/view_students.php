<?php
include 'db_connect.php';

// Check database connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Fetch all student data
$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);

// Check if query executed successfully
if (!$result) {
    die("ERROR: Could not execute $query. " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="/major_project/admin/admin_styles.css">
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
                <th>Actions</th>
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
                <td>
                    <a href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
