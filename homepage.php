
<?php
session_start();
require("includes/session.php");
require("includes/darkmode.php");

//action after logout button
if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
   // echo "<script>alert('This is an alert message!');</script>";
};
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="Styles/styles.css">
    <link rel="stylesheet" type="text/css" href="Styles/darkmode.css">
</head>
<body class="<?php echo getModeClass($mode); ?>">
<?php include ("templates/nav-bar.php");?>
<!-- inlcude masterpage header -->

<?php 
echo 'ID: '.$id.'<br>';
echo 'Hi user: '.$username;
?>
    <h2>Home page</h2>
    
    <form action="" method="POST">
        <input type="hidden" name="mode" value="<?php echo ($mode === 'light') ? 'dark' : 'light'; ?>">
        <button type="submit">Switch to <?php echo ($mode === 'light') ? 'Dark' : 'Light'; ?> Mode</button>
    </form>


    <form method="post" action="homepage.php">
        <input type="submit" name="Logout" value="Logout">    
    </form>
<?php 
include  "templates/nav-bar2.php"; 
?>

</body>
</html>