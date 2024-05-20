<?php

// Start the session
session_start();

//force user to unaithorize to restricted page
include("includes/security.php");

if(isset($_POST['submit'])){
    $name = $_POST['UserName'];
    $myPassword = $_POST['Password'];
    $id;


    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare the SQL query with placeholders
    $queryUser = "SELECT * FROM account WHERE username=? AND password=?";

    // Prepare the statement
    $statement = $connection->prepare($queryUser);

    // Bind parameters
    $statement->bind_param("ss", $name, $myPassword);

    // Execute the statement
    $statement->execute();

    // Get the result
    $result = $statement->get_result();

    // Check if a matching user is found
    if($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        
        // Store the username and user ID in session variables
        $_SESSION['session_username'] = $row['username'];
        $_SESSION['session_id'] = $row['id'];
        $_SESSION['session_roleId'] = $row['role_id'];

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

        if($row['username']==$name && $row['password']==$myPassword ){
            if($row['role_id']=='1' ){
                // Redirect to admin homepage
                header("Location: Pages/admin/dashboard.php");
                exit;
            }else{
                //Expected role is Staff or User
                //Check the status of account 
                if ($row["status"]=='active'){
                    //redirect to landing page based on role 
                    header("Location: Pages/admin/dashboard.php");
                    exit;
                }
                else{
                   
                    // Redirect to Staff homepage
                    header("Location: templates/status.php");
                    exit;     
                }
            }
            
        }
        else{
        //redirect to default page
        header("Location: Pages/admin/dashboard.php");
        exit;
        }
        
    } else {
        // Invalid username or password
        $error = "Invalid username or password";
       
        require_once("templates/alert-message.php");
        showAlertMsg("Username or Password is incorrect.", "danger");
    
    }

    // Close the statement and connection
    $statement->close();
    $connection->close();
}
?>
