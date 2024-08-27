<?php
session_start();

//force user to unaithorize to restricted page
include("includes/security.php");

if(isset($_POST['submit'])){
    $name = $_POST['UserName'];
    $myPassword = $_POST['Password'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $queryUser = "SELECT * FROM account WHERE username=?";

    $statement = $connection->prepare($queryUser);

    $statement->bind_param("s", $name);

    $statement->execute();

    $result = $statement->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($myPassword, $row['password'])) {
            // Passwords match, proceed with login
            // Store the username and user ID in session variables
            $_SESSION['session_username'] = $row['username'];
            $_SESSION['session_id'] = $row['id'];
            $_SESSION['session_role'] = $row['role'];
            $_SESSION['mode'] = 'light';

            // Set default values for the Reference data view
            $_SESSION['activeTab'] = 'tab1';
            $_SESSION['activeTabName'] = 'Species';

            // Check if the "Remember me" checkbox is checked
            if(isset($_POST['remember']) && $_POST['remember'] == 'on') {
                // Set cookies for username and password with expiry time
                setcookie('remember_username', $name, time() + (86400 * 30), "/"); // 30 days expiration
                setcookie('remember_password', $myPassword, time() + (86400 * 30), "/"); // 30 days expiration
            } else {
                // If "Remember me" checkbox is unchecked, delete the remember cookies
                setcookie('remember_username', '', time() - 3600, "/"); // set expiry time in the past to delete the cookie
                setcookie('remember_password', '', time() - 3600, "/"); // set expiry time in the past to delete the cookie
                
                // Unset cookies from current request
                unset($_COOKIE['remember_username']);
                unset($_COOKIE['remember_password']);
            }
            
            if ($row['role'] == 'Admin' && $row["status"] == 'active') {
                header("Location: Pages/admin/dashboard.php");
                exit;
            } else {
                if ($row["status"] == 'active') {
                    header("Location: Pages/admin/dashboard.php"); 
                    exit;
                } else {
                    header("Location: templates/status.php");
                    exit;
                }
            }
            
        } else {
            $error = "Invalid username or password";
            require_once("templates/alert-message.php");
            showAlertMsg("Username or Password is incorrect.", "danger");
        }
    } else {
        $error = "Invalid username or password";
        require_once("templates/alert-message.php");
        showAlertMsg("Username or Password is incorrect.", "danger");
    }
    $statement->close();
    $connection->close();
}
?>
