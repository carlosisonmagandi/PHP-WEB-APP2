<?php

// Check if user has set a preference
if(isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') {
    $mode = 'dark';
} else {
    $mode = 'light';
}

// Handle user's mode preference
if(isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    $_SESSION['mode'] = $mode;
}

// // Function to apply corresponding CSS class based on mode
// function getModeClass($mode) {
//     return ($mode === 'dark') ? 'dark-mode' : 'light-mode';
// }

// Check if the function exists before declaring it
if (!function_exists('getModeClass')) {
    // Function to apply corresponding CSS class based on mode
    function getModeClass($mode) {
        return ($mode === 'dark') ? 'sb-sidenav-dark' : 'sb-sidenav-light';
    }
}
?>

