<?php
include 'db_connect.php';

// Check if 'id' is provided in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch current data of the student based on the ID
    $query = "SELECT * FROM students WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);
}

// Handle the update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $program = $_POST['program'];
    $semester = $_POST['semester'];
    $roll_no = $_POST['roll_no'];
    $rfid_id = $_POST['rfid_id'];
    $level = $_POST['level'];
    $batch = $_POST['batch'];

    // Update query to modify the student data
    $query = "UPDATE students SET 
                name = '$name', 
                program = '$program', 
                semester = '$semester', 
                roll_no = '$roll_no', 
                rfid_id = '$rfid_id', 
                level = '$level', 
                batch = '$batch' 
              WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        $message = "Student updated successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="dashboard-container">
        <div class="main-content">
            <h2>Edit Student</h2>
            <!-- Display success or error message -->
            <?php if (isset($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <!-- Back Button -->
            <a href="view_students.php"
            style="display: inline-block; margin-bottom: 15px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px;">Back to Student List</a>

            <!-- Edit form to update student details -->
            <form action="" method="POST">
                <div class="fields">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="<?php echo $student['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="program">Program:</label>
                        <select id="program" name="program">
                            <option value="computer_engineering" <?php if($student['program'] == 'computer_engineering') echo 'selected'; ?>>Computer Engineering</option>
                            <option value="electrical_engineering" <?php if($student['program'] == 'electrical_engineering') echo 'selected'; ?>>Electrical Engineering</option>
                            <!-- Add other programs similarly -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select id="semester" name="semester">
                            <option value="1" <?php if($student['semester'] == 1) echo 'selected'; ?>>1</option>
                            <!-- Add other semesters similarly -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="roll_no">Roll Number:</label>
                        <input type="text" name="roll_no" value="<?php echo $student['roll_no']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="rfid_id">RFID ID:</label>
                        <input type="text" name="rfid_id" value="<?php echo $student['rfid_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Level:</label>
                        <select id="level" name="level">
                            <option value="diploma" <?php if($student['level'] == 'diploma') echo 'selected'; ?>>Diploma</option>
                            <option value="bachelor" <?php if($student['level'] == 'bachelor') echo 'selected'; ?>>Bachelor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="batch">Batch:</label>
                        <select name="batch" id="batch" required>
                            <?php
                            for ($year = 2081; $year >= 2060; $year--) {
                                $selected = ($student['batch'] == $year) ? 'selected' : '';
                                echo "<option value='$year' $selected>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update Student">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
