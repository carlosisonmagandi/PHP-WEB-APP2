<?php
session_start();
require("includes/session.php");
require("includes/darkmode.php");
require("includes/authentication.php");

// Action after logout button
if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

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
include("templates/nav-bar.php");
?>

<div class="container">
    <div class="tabset">
        <!-- Tab for stock -->
        <input type="radio" name="tabset" id="tabStock" aria-controls="Stock" <?php echo ($activeTab == 'tabStock') ? 'checked' : ''; ?> onclick="setActiveTab('tabStock')">
        <label for="tabStock">Stacked</label>
        <!-- Tab 1 -->
        <input type="radio" name="tabset" id="tab1" aria-controls="Request" <?php echo ($activeTab == 'tab1') ? 'checked' : ''; ?> onclick="setActiveTab('tab1')">
        <label for="tab1">To Request</label>
        <!-- Approved -->
        <input type="radio" name="tabset" id="Approved" aria-controls="Approved" <?php echo ($activeTab == 'Approved') ? 'checked' : ''; ?> onclick="setActiveTab('Approved')">
        <label for="Approved">Approved</label>

        <!-- Tab 2 -->
        <input type="radio" name="tabset" id="tab2" aria-controls="Deliver" <?php echo ($activeTab == 'tab2') ? 'checked' : ''; ?> onclick="setActiveTab('tab2')">
        <label for="tab2">To Deliver</label>
        <!-- Tab 3 -->
        <input type="radio" name="tabset" id="tab3" aria-controls="Receive" <?php echo ($activeTab == 'tab3') ? 'checked' : ''; ?> onclick="setActiveTab('tab3')">
        <label for="tab3">To Receive</label>
        <!-- Tab 4 -->
        <input type="radio" name="tabset" id="tab4" aria-controls="Completed" <?php echo ($activeTab == 'tab4') ? 'checked' : ''; ?> onclick="setActiveTab('tab4')">
        <label for="tab4">Completed</label>

        <div class="tab-panels">
            <section id="tabStock" class="tab-panel">
                <h2>Stock</h2>
                <p><strong>Stock list:</strong> This should be all the list of items on stock area</p>
            </section>
            <section id="Request" class="tab-panel">
                <h2>A. Request</h2>
                <p><strong>Request list:</strong> This should be all the list of request per Item (trees)</p>
            </section>
            <section id="Approved" class="tab-panel">
                <h2>Approved</h2>
                <p><strong>Approved list:</strong> This should be all the list of items Approved by the admin</p>
            </section>
            <section id="Deliver" class="tab-panel">
                <h2>B. Deliver</h2>
                <p><strong>Delivery:</strong> This state the current state of items that was approved by Admin to deliver/ donate</p>
            </section>
            <section id="Receive" class="tab-panel">
                <h2>C. Receive</h2>
                <p><strong>Receiving:</strong> This is where the state where the item is on the way to its destination</p>
            </section>
            <section id="Completed" class="tab-panel">
                <h2>D. Completed</h2>
                <p><strong>Completed:</strong> This is where the items that were received by requester (School)</p>
            </section>
        </div>
    </div>
</div>

<?php
include "templates/nav-bar2.php"; 
?>
</body>
</html>
