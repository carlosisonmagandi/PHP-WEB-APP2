<?php
require_once "db_connection.php";

// Static values
$title = 'Account Registration';
$status = 'unseen';
$landingPage = '/Pages/admin/manageAccount.php';


// Create prepared statement
$stmt = mysqli_prepare($connection, "INSERT INTO pushedNotification (title, landing_page, status, date_created, time_created, user_name) VALUES (?, ?, ?, CURDATE(), CURTIME(), ?)");
mysqli_stmt_bind_param($stmt, 'ssss', $title, $landingPage, $status, $userName);//$userName was declared in register.php

// Execute statement
if (mysqli_stmt_execute($stmt)) {
    showAlertMsg("Registered successfully!", "success");
    // echo "New record added to notification";
    } else {
        echo "Error: " . mysqli_error($connection);
}
// Close statement
mysqli_stmt_close($stmt);
// Close connection
mysqli_close($connection);
?>
