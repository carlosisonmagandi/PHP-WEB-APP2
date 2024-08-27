<?php
    if(isset($_SESSION['mode']) && $_SESSION['mode'] === 'dark') {// Check if user has set a preference
        $mode = 'dark';
    } else {
        $mode = 'light';
    }
    if(isset($_POST['mode'])) {// Handle user's mode preference
        $mode = $_POST['mode'];
        $_SESSION['mode'] = $mode;
    }
    if (!function_exists('getModeClass')) {// Check if the function exists before declaring it
        function getModeClass($mode) { // Function to apply corresponding CSS class based on mode
            return ($mode === 'dark') ? 'sb-sidenav-dark' : 'sb-sidenav-light';
        }
    }
?>

