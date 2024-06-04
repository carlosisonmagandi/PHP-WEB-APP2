<?php
// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Check if the URL matches a valid page on your website
$validPages = array(
    'Pages/admin/dashboard.php',
    'Pages/admin/manageOwnAccount.php',
    '/index.php',
    '/forgot-password-reset.php'
    
);

if (!in_array($currentUrl, $validPages)) {
    // Redirect to the 404 error page
    header("Location: templates/404.php");
    exit();

    // For debugging
    // echo "Current URL: $currentUrl<br>";
    // print_r($validPages);
}
?>
