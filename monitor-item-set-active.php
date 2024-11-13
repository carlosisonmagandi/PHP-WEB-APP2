<?php
session_start();
// $activeTab = isset($_SESSION['activeTab']) ? $_SESSION['activeTab'] : 'tab1';
if (isset($_POST['activeTab'])) {
    $_SESSION['activeTab'] = $_POST['activeTab'];
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No tab specified']);
}
?>
