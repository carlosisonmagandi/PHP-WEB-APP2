<?php
// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Check if the URL matches a valid page on your website
// You would need to define your own logic to determine valid pages
$validPages = array(
    'Pages/admin/dashboard.php',
    'Pages/admin/manageOwnAccount.php'
    
);

if (!in_array($currentUrl, $validPages)) {
    // Redirect to the 404 error page
    include("../templates/404.php");
    exit();
}
?>
