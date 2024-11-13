<?php
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");

if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}
require("../includes/adminOnlyAuth.php");

// Get the active tab from session
$activeTab = isset($_SESSION['activeTab']) ? $_SESSION['activeTab'] : 'tab1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Item Monitoring</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/Styles/monitor-item-trees.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function setActiveTab(tabId) {
            $.ajax({
                url: '/monitor-item-set-active.php',
                type: 'POST',
                data: { activeTab: tabId },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        console.log("Active tab updated successfully");
                    } else {
                        console.error("Failed to update active tab: " + res.message);
                    }
                },
                error: function() {
                    console.error("An error occurred while updating the active tab");
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var activeTabId = '<?php echo $activeTab; ?>';
            document.getElementById(activeTabId).checked = true;
        });
    </script>
</head>
<body>

<?php 
include("../templates/nav-bar.php");
?>

<div class="container">
    <div class="tabset">
        
        <!-- Tab 1 -->
        <input type="radio" name="tabset" id="tab1" aria-controls="Request" <?php echo ($activeTab == 'tab1') ? 'checked' : ''; ?> onclick="setActiveTab('tab1')">
        <label for="tab1">Waiting for approval</label>
        <!-- Approved -->
        <input type="radio" name="tabset" id="Approved" aria-controls="Approved" <?php echo ($activeTab == 'Approved') ? 'checked' : ''; ?> onclick="setActiveTab('Approved')">
        <label for="Approved">Approved</label>
        <!-- Tab 2 -->
        <input type="radio" name="tabset" id="tab2" aria-controls="Deliver" <?php echo ($activeTab == 'tab2') ? 'checked' : ''; ?> onclick="setActiveTab('tab2')">
        <label for="tab2">Completed</label>

        <input type="radio" name="tabset" id="Rejected" aria-controls="Rejected" <?php echo ($activeTab == 'Rejected') ? 'checked' : ''; ?> onclick="setActiveTab('Rejected')">
        <label for="Rejected">Rejected</label>
 
     

        <div class="tab-panels">
            <section id="tabStock" class="tab-panel">
                <!-- call display for waiting for approval -->
                <?php  include("../Admin/Requests/WaitingForApproval/request-pending-display.php"); ?>
            </section>
            <section id="Approved" class="tab-panel">
                <?php  include("../Admin/Requests/Approved/request-approved-display.php"); ?>
            </section>
            <section id="Completed" class="tab-panel">
                <?php  include("../Admin/Requests/Completed/request-completed-display.php"); ?>
            </section>
            <section id="Rejected" class="tab-panel">
                <?php  include("../Admin/Requests/Rejected/request-rejected-display.php"); ?>
                
            </section>
            
        </div>
    </div>
</div>

<?php
include "../templates/nav-bar2.php"; 
?>
</body>
</html>
