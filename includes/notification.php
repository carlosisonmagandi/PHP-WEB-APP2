<?php
require_once "db_connection.php";

$title = 'Account Registration';// Static values
$status = 'unseen';
$landingPage = '/Pages/admin/manageAccount.php';

$stmt = mysqli_prepare($connection, "INSERT INTO pushedNotification (title, landing_page, status, date_created, time_created, user_name) VALUES (?, ?, ?, CURDATE(), CURTIME(), ?)");
mysqli_stmt_bind_param($stmt, 'ssss', $title, $landingPage, $status, $userName);//$userName was declared in register.php

if (mysqli_stmt_execute($stmt)) {// Execute statement
    showAlertMsg("Registered successfully!", "success");
    // echo "New record added to notification";
    } else {
        echo "Error: " . mysqli_error($connection);
}
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
