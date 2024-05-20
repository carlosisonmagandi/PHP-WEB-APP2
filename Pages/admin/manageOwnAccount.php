<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");

// Assuming you have a database connection established, replace connection with your actual database connection
require_once "../../includes/db_connection.php";

// Check if the user is logged in
if (!isset($_SESSION['session_id'])) {
    // Redirect the user to login page or handle accordingly
    header("Location: login.php");
    exit(); // Stop execution to prevent further code execution
}

// Assuming you have a function to safely fetch the user's data from the database using prepared statements
function fetchUserData($connection, $userId) {
    $query = "SELECT id, username, password FROM account WHERE id = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("i", $userId); // Assuming id is an integer
    $statement->execute();
    $result = $statement->get_result();
    $userData = $result->fetch_assoc();
    $statement->close();
    return $userData;
}

// Fetch user data
$userData = fetchUserData($connection, $_SESSION['session_id']);

?>

<head>
    <!-- Head content -->
</head>

<body>
    <!-- Navbar -->
    <?php include("../../templates/nav-bar.php"); ?>

    <!-- Alert message -->
    <?php 
    require_once("../../templates/alert-message.php");

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve submitted values
        $newUsername = $_POST['username'];
        $newPassword = $_POST['password'];

        // Function to check if the password meets the specified criteria
        function validatePassword($newPassword) {
            return (strlen($newPassword) >= 5 && preg_match('/\d/', $newPassword) && preg_match('/[A-Z]/', $newPassword) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $newPassword));
        }

        if (validatePassword($newPassword)) {
            // Prepare and execute UPDATE query
            $updateQuery = "UPDATE account SET username = ?, password = ? WHERE id = ?";
            $updateStatement = $connection->prepare($updateQuery);
            $updateStatement->bind_param("ssi", $newUsername, $newPassword, $_SESSION['session_id']); // this is the session id 
            $updateStatement->execute();

            // Check if the update was successful
            if ($updateStatement->affected_rows > 0) {
                // Display success message
                showAlertMsg("Profile updated successfully.", "success");
                // Update the userData variable with the new values
                $userData['username'] = $newUsername;
                $userData['password'] = $newPassword;
            } else {
                // Display error message
                //showAlertMsg("Failed to update profile. Please try again.", "danger");
            }

            // Close the update statement
            $updateStatement->close();
        }
        else{
            showAlertMsg("Password must contain atleast one Uppercase letter, one number and one special character.", "danger");
        }
        
    }
    ?>

    <style>
        body {
            background-image: url('/Images/edit-account.png');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: right bottom;
            font-family: 'Poppins', sans-serif;

        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%; /* Cover the entire body */
            height: 100%;
            background-color: rgba(255, 255, 255, 0.3); /* Adjust opacity here */
            z-index: -1; /* Ensure the pseudo-element is behind other content */
        }
       
        @media screen and (min-width: 320px) and (max-width: 425px) {
            #container{
                background-color: rgba(255, 255, 255, 0.8);
            }
                
            } 
    </style>
    <div id="container" class="container-fluid mt-7" style="padding:5%;">
        <div class="row justify-content-left">
            <div class="col-md-5">
                <form method="POST">
                    <!-- Form fields -->
                    <h1>Edit Account</h1><br>
                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" class="form-control full-width" id="id" name="id" value="<?php echo $userData['id']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">User Name</label>
                        <input type="text" class="form-control full-width" id="username" name="username" value="<?php echo $userData['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control full-width" id="password" name="password" value="<?php echo $userData['password']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary full-width" style='background-color:#5CAB7D; border:none;float:right'>Update</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Navbar 2 -->
    <?php include("../../templates/nav-bar2.php"); ?>

    <!-- Script to update the input fields dynamically -->
    <script>
        <?php
        // Echo JavaScript code to update the input fields with the new values
        echo "document.getElementById('username').value = '" . $userData['username'] . "';";
        echo "document.getElementById('password').value = '" . $userData['password'] . "';";
        ?>
    </script>

</body>

</html>
