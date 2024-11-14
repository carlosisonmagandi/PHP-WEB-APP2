<?php
require_once("includes/db_connection.php");
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
        <title>PENRO Login</title>
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
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="index.php">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="UserName" id="UserName" placeholder="Input your username" value="<?php echo isset($_POST['UserName']) ? htmlspecialchars($_POST['UserName']) : (isset($_COOKIE['remember_username']) ? htmlspecialchars($_COOKIE['remember_username']) : ''); ?>" />
                                            <label for="UserName">User Name</label>
                                        </div>

                                            <div class="form-floating mb-3">
                                                <div class="input-group">
                                                    <input required type="password" class="form-control" placeholder="Input your password" id="password" name="Password" value="<?php echo isset($_POST['Password']) ? htmlspecialchars($_POST['Password']) : (isset($_COOKIE['remember_password']) ? htmlspecialchars($_COOKIE['remember_password']) : ''); ?>" />
                                                    <!-- Eye Icon inside the input field -->
                                                    <span class="input-group-text" id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                                <!-- <label for="inputPassword"></label> -->
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-label" type="checkbox" name="remember"> Remember me<br>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="/forgot-password.php">Forgot Password?</a>
                                                <input class="btn btn-primary" type="submit" name="submit" value="Login">
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

        <!-- Add Font Awesome CDN -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        
        <!-- JavaScript to toggle password visibility -->
        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('click', function (e) {
                // Toggle the type attribute
                const type = passwordField.type === 'password' ? 'text' : 'password';
                passwordField.type = type;

                // Toggle the icon
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        </script>
    </body>

</html>
