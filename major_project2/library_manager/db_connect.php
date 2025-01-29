<?php
// db_connect.php

// Connect to the admin database
$admin_conn = mysqli_connect('localhost', 'root', '', 'admin1');
if (!$admin_conn) {
    die("Connection failed to admin database: " . mysqli_connect_error());
}

// Connect to the library_management database
$library_conn = mysqli_connect('localhost', 'root', '', 'library_management1');
if (!$library_conn) {
    die("Connection failed to library_management database: " . mysqli_connect_error());
}
?>
