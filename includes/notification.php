<?php
require_once "db_connection.php";

// Check if title and landing_page are set in the POST request
if(isset($_POST['title'], $_POST['landing_page'], $_POST['status'],$_POST['username'])) {
    // Sanitize input data
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $landingPage = mysqli_real_escape_string($connection, $_POST['landing_page']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    
    
    // Create prepared statement
   $stmt = mysqli_prepare($connection, "INSERT INTO pushedNotification (title, landing_page, status, date_created, time_created,user_name) VALUES (?, ?, ?, CURDATE(), CURTIME(),?)");
   mysqli_stmt_bind_param($stmt, 'ssss', $title, $landingPage, $status, $username);


    // Execute statement
    if (mysqli_stmt_execute($stmt)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "Title and landing page not provided.";
}

// Close connection
mysqli_close($connection);
?>
