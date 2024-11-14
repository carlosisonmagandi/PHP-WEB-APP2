<?php
session_start();

if (isset($_POST['tabName'])) {
    $tabName = $_POST['tabName'];
    $_SESSION['activeTab']='tab1';
    if ($tabName === 'Trees') {
        $_SESSION['activeTabName'] = 'Species';
    } elseif ($tabName === 'Vehicle') {
        $_SESSION['activeTabName'] = 'Vehicle Type';
    } elseif ($tabName === 'Equipment') {
        $_SESSION['activeTabName'] = 'Equipment Type';
    }
    echo $_SESSION['activeTab'];
}
?>
