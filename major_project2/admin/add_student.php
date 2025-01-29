<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $program = $_POST['program'];
    $semester = $_POST['semester'];
    $roll_no = $_POST['roll_no'];
    $rfid_id = $_POST['rfid_id'];
    $level = $_POST['level'];
    $batch = $_POST['batch'];

    $query = "INSERT INTO students (name, program, semester, roll_no, rfid_id, level, batch) 
              VALUES ('$name', '$program', '$semester', '$roll_no', '$rfid_id', '$level', '$batch')";
    
    if (mysqli_query($conn, $query)) {
        $message = "Student added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="dashboard-container">
        <div class="main-content">
            <h2>Add Student</h2>
            <?php if (isset($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="fields">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" placeholder="Enter the name of student" required>
                </div>
                <div class="form-group">
                    <label for="program">Program:</label>
                    <select id="program" name="program">
            <option value="Computer Engineering">Computer Engineering</option>
            <option value="Electrical Engineering">Electrical Engineering</option>
            <option value="E & E Engineering">E & E Engineering</option>
            <option value="Civil Engineering">Civil Engineering</option>
            <option value="HA">HA</option>
            <option value="Lab Technician">Lab Technician</option>
            </select>
            </div>
                <div class="form-group">
                    <label for="level">Level:</label>
                    <select id="level" name="level">
        <option value="Diploma">Diploma</option>
        <option value="Bachelor">Bachelor</option>
        </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester:</label>
                    <select id="semester" name="semester">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="batch">Batch:</label>
                    <select name="batch" id="batch" required>
                    <?php
                    for ($year = 2081; $year >= 2060; $year--) {
                    echo "<option value='$year'>$year</option>";
                    }
                    ?>
                    </select>

                </div>
                <div class="form-group">
                    <label for="roll_no">Roll Number:</label>
                    <input type="text" name="roll_no" placeholder="Enter the roll number of student" required>
                </div>
                <div class="form-group">
                    <label for="rfid_id">RFID ID:</label>
                    <input type="text" name="rfid_id" placeholder="Enter the rfid number of student" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Add Student">
                </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
