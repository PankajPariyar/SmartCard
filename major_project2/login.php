<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Clear any existing session data
session_unset();
session_destroy();

// Start a new session
session_start();
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_id";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
   </head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action=" " method="post" autocomplete="off">
            <label for="username_or_email">Username or Email:</label>
            <input type="text" id="username_or_email" name="username_or_email" required autocomplete="off">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required autocomplete="off">
            <input type="submit" value="Login">
        </form>
    </div>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT usertype FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $usertype = $row['usertype'];

        if ($usertype == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($usertype == 'canteen_manager') {
            header("Location: canteen_dashboard.php");
        } elseif ($usertype == 'library_manager') {
            header("Location: library_dashboard.php");
        } elseif ($usertype == 'student') {
            header("Location: student_dashboard.php");
        }
    } else {
        echo "Invalid username or password";
    }
}

$conn->close();
?>

</body>
</html>
