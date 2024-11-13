<?php
// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

$validPages = array(// Check if the URL matches a valid page on your website
    'Pages/admin/dashboard.php',
    'Pages/admin/manageOwnAccount.php',
    '/index.php',
    '/forgot-password-reset.php'
);
if (!in_array($currentUrl, $validPages)) {
    header("Location: templates/404.php");// Redirect to the 404 error page
    exit();
    // For debugging
    // echo "Current URL: $currentUrl<br>";
    // print_r($validPages);
}
?>
