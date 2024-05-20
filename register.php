<?php 
//database connection
require_once("includes/db_connection.php");
require_once("templates/alert-message.php");

if(isset($_POST['submit'])){
    $confirmPassword = $_POST['confirmPassword'];
    $password= $_POST['password'];
    $userName = $_POST['userName'];
    //$msg= $_POST['msg'];

    // Function to check if the password meets the specified criteria
    function validatePassword($password) {
        return (strlen($password) >= 5 && preg_match('/\d/', $password) && preg_match('/[A-Z]/', $password) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password));
    }

    if($password == $confirmPassword){
        if (validatePassword($password)) {
            
              // Define the SQL query with filtering based on username and password
                $queryUser = "INSERT INTO account (username, password, role) 
                VALUES ('$userName', '$password', 'Staff')";

                // Execute the query
                $sqlUser = mysqli_query($connection, $queryUser);

                // Check for errors in the query
                if (!$sqlUser) {
                    die("Query failed: " . mysqli_error($connection));
                }
        } else {
            //echo "<script>alert('Password must be at least 5 characters long and contain at least 1 number, 1 uppercase letter, and 1 special character.');</script>";
        }
    } else {
        showAlertMsg("Password and confirm password didnt match.", "danger");
        $userName = $_POST['userName'];
        

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- <link href="/Styles/sb-admin/sb-admin-styles.css" rel="stylesheet" /> -->
        
    <!--Stylesheet-->
    <link rel="stylesheet" href="Styles/register.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <form action="" method="post">
            <input type="text" id="userName" name="userName" placeholder="User Name" 
                <?php 
                    if(isset($_POST['userName'])){
                        if ($password != $confirmPassword) { echo 'value="' . htmlspecialchars($userName) . '"'; } 
                    }  
                ?>
            ><br><br>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" oninput="strengthChecker()" placeholder="Password">
                    <span id="toggle" onclick="toggle()">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <div id="strength-bar"></div>
                
                <p id="msg" name='msg'></p>
                <br>
                <div class="confirmPassword-wrapper">
                    <input type="password" id="confirmPassword" name="confirmPassword"  placeholder="Confirm Password">
                    <span id="toggle2" onclick="toggle2()">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                
                <br>
                <input type="submit" name="submit" value="Register" id="registerBtn">
            </form>
        </div>
    </div>
    <!--Script-->
    <script src="Javascript/passwordChecker.js"></script>
    <script>

        $(document).ready(function(){
            $("#registerBtn").click(function(){

                var userName = $("#userName").val();
                var password= $("#password").val();
                var confirmPassword= $("#confirmPassword").val();

                if(password==confirmPassword){
                    $.ajax({
                        url: 'includes/notification.php', // URL where your PHP script is located
                        type: 'POST',
                        data: {
                            title: "Account Registration",
                            status: "unseen",
                            landing_page: "Pages/admin/manageAccount.php",
                            username: userName, 
                            
                        },
                        success: function(response){
                            // Handle success response
                            
                            alert(response); // You can replace this with any other action you want
                            
                        },
                        error: function(xhr, status, error){
                            // Handle error
                            console.log(error);
                        }
                    });
                }else{
                    // Passwords don't match, retain input values
                    $("#password").val(password);
                    $("#confirmPassword").val(confirmPassword);
                }    
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/Javascript/sb-admin/sb-admin-script.js"></script>
</body>
</html>
