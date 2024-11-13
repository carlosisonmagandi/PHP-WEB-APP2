<?php
if ($_SESSION['session_role']!='Admin') {// Check if the user is logged in
    header("Location: ../../templates/page-restriction.php");
    exit();
}
?>