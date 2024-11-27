<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");

require_once "../../includes/db_connection.php";
if (!isset($_SESSION['session_id'])) {
    header("Location: login.php");
    exit();
}

require("../../includes/authentication.php");

// if ($_SESSION['session_role']!='Admin') {// Check if the user is logged in
//     header("Location: ../../templates/page-restriction.php");
//     exit();
// }

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
    <?php //include("../../templates/nav-bar.php"); ?>

    <?php 
    isset($_SESSION['session_role']) 
    ? include($_SESSION['session_role'] == 'Field_Staff' ? "../../Pages/FieldStaff/nav-bar.php" : "../../templates/nav-bar.php")
    : print("No session role found.");
    ?>

    
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
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Prepare the update query
            $updateQuery = "UPDATE account SET username = ?, password = ? WHERE id = ?";
            $updateStatement = $connection->prepare($updateQuery);
            $updateStatement->bind_param("ssi", $newUsername, $hashedPassword, $_SESSION['session_id']);
            $updateStatement->execute();

            if ($updateStatement->affected_rows > 0) {
                showAlertMsg("Profile updated successfully.", "success");
                $userData['username'] = $newUsername;
                $userData['password'] = $newPassword;
            } else {
                showAlertMsg("Failed to update profile. Please try again.", "danger");
            }
            $updateStatement->close();
        } else {
            showAlertMsg("Password must contain at least one uppercase letter, one number, and one special character.", "danger");
        }
    }
    ?>
    <style>
        /* Your styles here */
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
    <?php //include("../../templates/nav-bar2.php"); ?>
    <?php 
    isset($_SESSION['session_role']) 
    ? include($_SESSION['session_role'] == 'Field_Staff' ? "../../Pages/FieldStaff/nav-bar2.php" : "../../templates/nav-bar2.php")
    : print("No session role found.");
    ?>

    <script>
        <?php
        echo "document.getElementById('username').value = '" . $userData['username'] . "';";
        echo "document.getElementById('password').value = '" . $userData['password'] . "';";
        ?>
    </script>

</body>

</html>
