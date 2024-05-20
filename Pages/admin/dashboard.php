
<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");
require("../../includes/authentication.php");


//action after logout button
if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: ../../index.php");
    exit;
   // echo "<script>alert('This is an alert message!');</script>";
};
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../../Styles/styles.css">
    <link rel="stylesheet" type="text/css" href="../../Styles/darkmode.css">
    

</head>
<!-- <body class="<?php echo getModeClass($mode); ?>"> -->
<body >
<?php include ("../../templates/nav-bar.php");?>
<!-- inlcude masterpage header -->


<div class="container-fluid mt-5">
    <div class="row ">
        <?php 
            echo 'ID: '.$id.'<br>';
            echo 'Hi user: '.$username.'<br>';
            echo 'My role id: '.$roleId.'<br>';
            //Getting the current URL
            echo $_SERVER['PHP_SELF']; 
        ?>
    <h2>Admin Landing page</h2>
    
    <!-- <form action="" method="POST">
        <input type="hidden" name="mode" value="<?php echo ($mode === 'light') ? 'dark' : 'light'; ?>">
        <button type="submit">Switch to <?php echo ($mode === 'light') ? 'Dark' : 'Light'; ?> Mode</button>
    </form>
    <form method="post" action="">
        <input type="submit" name="Logout" value="Logout">    
    </form> -->

    <!-- <h1 class="mt-4">Dashboard</h1> -->
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Active Cases</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Seized  Items</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Completed Cases</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Urgent Cases</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>    
</div>

<?php 
include  "../../templates/nav-bar2.php"; 
?>

</body>
</html>