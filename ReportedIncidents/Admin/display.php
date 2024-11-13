<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");
require("../../includes/authentication.php");

if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}
// require("../includes/adminOnlyAuth.php");

// Get the active tab from session
$activeTab = isset($_SESSION['activeTab']) ? $_SESSION['activeTab'] : 'tab1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Item Monitoring</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/Styles/monitor-item-trees.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>

<?php 
include("../../templates/nav-bar.php");
?>



<?php
include "../../templates/nav-bar2.php"; 
?>
</body>
</html>
