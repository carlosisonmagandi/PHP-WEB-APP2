<?php
session_start();

if (isset($_POST['activeTab'])) {
    $_SESSION['activeTab'] = $_POST['activeTab'];
    $_SESSION['activeTabName'] = $_POST['activeTabName'];
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No tab specified']);
}
?>
