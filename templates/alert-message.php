<?php
$message;
$alertType;
function showAlertMsg($message, $alertType , $closable = true) {
    echo '<div class="alert alert-' . $alertType . ' alert-dismissible">';
    if ($closable) {
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    }
    echo '<strong><span>' . ucfirst($alertType) . '<span>!</strong> ' . $message;
    echo '</div>';
}

?>
