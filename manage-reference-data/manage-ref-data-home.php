<?php 
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");

// Action after logout button
if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reference data </title>
    <link rel="stylesheet" type="text/css" href="/Styles/manage-ref-data-home.css">
    <!-- Assuming you are using Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php 
include("../templates/nav-bar.php");
?>

<div class="container">
    <div class="centered">
        <a href="/manage-reference-data/manage-ref-data.php" class="button" ><i class="fas fa-tree"></i> </a>
        <a class="button"><i class="fas fa-car"></i> </a>
        <a class="button"><i class="fas fa-tools"></i></a>
    </div>
</div>

<?php 
include("../templates/nav-bar2.php");
?>
</body>
</html>
