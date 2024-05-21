<?php

//database connection
require_once("includes/db_connection.php");

//login form
require("login.php");

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="/Styles/sb-admin/sb-admin-styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <style>
             body {
            background-image: url('/Images/login-nature-icon.png');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: right bottom;
        }
        .card {
                /*background-color: rgba(255, 255, 255, 0.7);  Adjust the opacity here */
            }
        
        .btn{
            border:none; 
            background-color:#5CAB7D;
            padding-right:10%;
            padding-left:10%;
        }
        .btn:hover{
            border:none; 
            background-color:#8BD3B3;
            padding-right:10%;
            padding-left:10%;
        }
        @media (max-width: 992px) {
            .card {
                background-color: rgba(255, 255, 255, 0.8);  Adjust the opacity here
            }
        }
        </style>
    </head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-left">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5" >
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="index.php">
                                            <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="UserName" value="<?php echo isset($_POST['UserName']) ? htmlspecialchars($_POST['UserName']) : (isset($_COOKIE['remember_username']) ? htmlspecialchars($_COOKIE['remember_username']) : ''); ?>" />
                                                <label for="inputEmail">User Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                            <input required type="password" class="form-control" name="Password" value="<?php echo isset($_POST['Password']) ? htmlspecialchars($_POST['Password']) : (isset($_COOKIE['remember_password']) ? htmlspecialchars($_COOKIE['remember_password']) : ''); ?>" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-label" type="checkbox" name="remember" > Remember me<br>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <input class="btn btn-primary" type="submit" name="submit" value="Login"></a>
                                            </div>
                                            <br>
                                        </form>
                                        <?php if(isset($error)) { echo $error; } ?>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="/register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <?php 
            include ("templates/footer.php");
            ?>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- <script src="js/scripts.js"></script> -->
    </body>
</html>
