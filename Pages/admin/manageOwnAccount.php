<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");

require_once "../../includes/db_connection.php";
if (!isset($_SESSION['session_id'])) {
    header("Location: login.php");
    exit();
}
function fetchUserData($connection, $userId) {
    $query = "SELECT id, username, password FROM account WHERE id = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("i", $userId); // i is for integer and s is for string
    $statement->execute();
    $result = $statement->get_result();
    $userData = $result->fetch_assoc();
    $statement->close();
    return $userData;
}
$userData = fetchUserData($connection, $_SESSION['session_id']);
?>
<body>
    <!-- Navbar -->
    <?php include("../../templates/nav-bar.php"); ?>
    <!-- Alert message -->
    <?php 
    require_once("../../templates/alert-message.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newUsername = $_POST['username'];
        $newPassword = $_POST['password'];
        function validatePassword($newPassword) {
            return (strlen($newPassword) >= 5 && preg_match('/\d/', $newPassword) && preg_match('/[A-Z]/', $newPassword) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $newPassword));
        }
        if (validatePassword($newPassword)) {
            $updateQuery = "UPDATE account SET username = ?, password = ? WHERE id = ?";
            $updateStatement = $connection->prepare($updateQuery);
            $updateStatement->bind_param("ssi", $newUsername, $newPassword, $_SESSION['session_id']); // this is the session id 
            $updateStatement->execute();

            if ($updateStatement->affected_rows > 0) {
                showAlertMsg("Profile updated successfully.", "success");
                $userData['username'] = $newUsername;
                $userData['password'] = $newPassword;
            } else {
                // Display error message
                //showAlertMsg("Failed to update profile. Please try again.", "danger");
            }
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
            background-color: rgba(255, 255, 255, 0.3);
            z-index: -1;
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
                    <h1>Edit Account</h1><br><!-- Form fields -->
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

    <script>
        <?php
        // Echo JavaScript code to update the input fields with the new values
        echo "document.getElementById('username').value = '" . $userData['username'] . "';";
        echo "document.getElementById('password').value = '" . $userData['password'] . "';";
        ?>
    </script>

</body>

</html>
