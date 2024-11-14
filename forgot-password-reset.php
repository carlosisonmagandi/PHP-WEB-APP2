<?php
require_once("includes/db_connection.php");
require_once("templates/alert-message.php");
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!--Stylesheet-->
    <link rel="stylesheet" href="Styles/register.css">

    <!-- flex style -->
    <style>
        body {
            background-image: url('/Images/forgot-password.png');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: right bottom;
        }
        * {
        box-sizing: border-box;
        }

        .flex-container {
        display: flex;
        flex-direction: row;
        padding:10px;
        }

        .flex-item-left {
        
        flex: 50%;
        }

        /* Responsive layout - makes a one column-layout instead of two-column layout */
        @media (max-width: 800px) {
        .flex-container {
            flex-direction: column;
        }

        .wrapper{
            top:450px
        }
        }
    </style>
    
</head>
<body>
    <div class="wrapper-password-reset">
        <form action="" method="post">
            <div class="flex-container">
                <div class="flex-item-left">
                    <h3 class="text-center font-weight-light my-4">Password Reset</h3>
                    <div class="container" style="padding: 10px;">
                        <br><br>
                        <div class="password-wrapper">  
                            <input require type="password" id="password" name="password" oninput="strengthChecker()" placeholder="Enter New Password" >
                            <span id="toggle" onclick="toggle()">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div id="strength-bar"></div>
                        
                        <p id="msg" name='msg'></p>
                        <br>
                        <div class="confirmPassword-wrapper">
                            <input require type="password" id="confirmPassword" name="confirmPassword"  placeholder="Confirm Password" >
                            <span id="toggle2" onclick="toggle2()">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <br>
                        <input type="submit" name="submit" value="Submit" id="submit">
                        <a style="color:red;font-size:12px;">**Password must contain atleast one number,special character and Uppercase letter.</a>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="card-footer text-center py-3">
            <div class="small">
                <a href="/register.php" style="color:blue;">Need an account? Sign up!</a>
                    <span><strong> | </strong></span>
                <a href="/index.php" style="color:blue;">Already have an account? Sign in!</a>
            </div>                                
        </div>
    </div>
    <!--Script-->
    <script src="Javascript/passwordChecker.js"></script>
    
    <script>
        $(document).ready(function() {
            if(sessionStorage.getItem("forgotPasswordId")=='' ||sessionStorage.getItem("forgotPasswordId")==null){
                window.location.href = 'templates/401.php';
            }
        });
        document.getElementById('submit').addEventListener('click', function(event) {
             event.preventDefault();
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
    
            $.ajax({
                url: 'forgot-password-update.php',
                type: 'POST',
                data: { 
                    forgotPasswordId: sessionStorage.getItem("forgotPasswordId"),
                    password: password,
                    confirmPassword: confirmPassword 
                },
                success: function(response) {
                    if (response.status === 'success') {

                        alert(response.message);
                        sessionStorage.clear();
                        window.location.href = '/index.php';
                    } else {
                       
                        alert(response.message);
                    }
                    // console.log(response);
                }
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/Javascript/sb-admin/sb-admin-script.js"></script>
</body>
</html>