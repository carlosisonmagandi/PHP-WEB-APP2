<?php
require_once("includes/db_connection.php");
require_once("templates/alert-message.php");

session_start();
$response = array('status' => '', 'message' => '');

if (isset($_POST['forgotPasswordId'])) {
    $_SESSION['forgotPasswordId'] = $_POST['forgotPasswordId'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Function to check if the password meets the specified criteria
    function validatePassword($password) {
        return (strlen($password) >= 5 && preg_match('/\d/', $password) && preg_match('/[A-Z]/', $password) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password));
    }

    if ($password == $confirmPassword) {
        if (validatePassword($password)) {
            // Update the password in the database
            $queryUpdate = "UPDATE account SET password='" . mysqli_real_escape_string($connection, $password) . "' WHERE id='" . mysqli_real_escape_string($connection, $_SESSION['forgotPasswordId']) . "'";
            if (mysqli_query($connection, $queryUpdate)) {
                $response['status'] = 'success';
                $response['message'] = 'Success! Password updated.';
                
            } else {
                $response['status'] = 'danger';
                $response['message'] = 'Error updating password. Please try again.';
            }
        } else {
            $response['status'] = 'danger';
            $response['message'] = 'Password must be at least 5 characters long and contain at least 1 number, 1 uppercase letter, and 1 special character.';
        }
    } else {
        $response['status'] = 'danger';
        $response['message'] = 'Passwords did not match.';
    }
} else {
    $response['status'] = 'danger';
    $response['message'] = 'Error: forgotPasswordId not set.';
}
header('Content-Type: application/json');
echo json_encode($response);
?>
