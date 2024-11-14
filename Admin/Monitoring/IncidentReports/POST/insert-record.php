<?php
session_start();
require_once("../../../../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if ($data) {
        $created_by = $_SESSION['session_username'];
        $inc_reports_id = $data['inc_reports_id'] ;
        $action_description = $data['action_description'].$created_by;
        $updated_by = $_SESSION['session_username'];

        $query = "INSERT INTO incident_report_monitoring (inc_reports_id, action_description, created_by, updated_by) 
                  VALUES (?, ?, ?, ?)";
 
        if ($stmt = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($stmt, "ssss", $inc_reports_id, $action_description, $created_by, $updated_by);

            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(["message" => "Record successfully inserted!"]);
            } else {
                echo json_encode(["error" => "Error executing query: " . mysqli_error($connection)]);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(["error" => "Error preparing the query: " . mysqli_error($connection)]);
        }
    } else {
        echo json_encode(["error" => "Invalid JSON data"]);
    }
}

mysqli_close($connection);
?>
