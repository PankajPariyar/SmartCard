<?php
// process_payment.php

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rfid_id = $_POST['rfid_id'];

    // Fetch student data using RFID ID
    $student_result = mysqli_query($conn, "SELECT * FROM students WHERE rfid_id = '$rfid_id'");
    $student = mysqli_fetch_assoc($student_result);

    // Fetch unpaid dues
    $dues_result = mysqli_query($conn, "SELECT * FROM dues WHERE student_id = {$student['id']} AND status = 'unpaid'");
    $total_due = 0;
    while ($due = mysqli_fetch_assoc($dues_result)) {
        $total_due += $due['amount'];
    }

    // Check if balance is sufficient
    if ($student['card_balance'] >= $total_due) {
        // Deduct balance and mark dues as paid
        mysqli_query($conn, "UPDATE students SET card_balance = card_balance - $total_due WHERE id = {$student['id']}");
        mysqli_query($conn, "UPDATE dues SET status = 'paid' WHERE student_id = {$student['id']} AND status = 'unpaid'");
        mysqli_query($conn, "INSERT INTO transactions (student_id, action) VALUES ({$student['id']}, 'paid_due')");

        echo "Payment successful!";
    } else {
        echo "Insufficient balance!";
    }
}
?>
