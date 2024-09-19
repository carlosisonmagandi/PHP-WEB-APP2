<?php
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");

// Action after logout button
if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

// Get the active tab from session
$activeTab = isset($_SESSION['activeTab']) ? $_SESSION['activeTab'] : 'tab1';
$activeTabName = isset($_SESSION['activeTabName']) ? $_SESSION['activeTabName'] : ''; // Default value if not set
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage reference data</title>
    <link rel="stylesheet" type="text/css" href="/Styles/manage-ref-data.css">
    <link rel="stylesheet" type="text/css" href="/Styles/breadCrumbs.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        function setActiveTab(tabId, tabName) {
            $.ajax({
                url: '/manage-reference-data/manage-ref-data-tab.php',
                type: 'POST',
                data: { activeTab: tabId, activeTabName: tabName },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        //To check if the click was successfully working

                        updateActiveTabName(tabName);
                    } else {
                        console.error("Failed to update active tab: " + res.message);
                    }
                },
                error: function() {
                    console.error("An error occurred while updating the active tab");
                }
            });
        }

        function updateActiveTabName(tabName) {
            var breadcrumbElement = document.querySelector('.breadcrumb .active');
            if (breadcrumbElement) {
                breadcrumbElement.textContent = tabName;
            }
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

<!-- Prefixfree -->
<script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript"></script>

<div class="container">
    <!-- a simple div with some links -->
    <?php if ($_SESSION['mode'] == 'light'): ?>
        <div class="breadcrumb flat">
            <a href="/manage-reference-data/manage-ref-data-home.php">Manage Reference Data</a>
            <a href="#">Equipments</a>
            <a href="#" class="active"><?php echo $activeTabName; ?></a>
        </div>
    <?php else: ?>
        <div class="breadcrumb">
            <a href="/manage-reference-data/manage-ref-data-home.php">Manage Reference Data</a>
            <a href="#">Equipments</a>
            <a href="#" class="active"><?php echo $activeTabName; ?></a>
        </div>
    <?php endif; ?>

    <div class="tabset">
        <!-- Tab 1 -->
        <input type="radio" name="tabset" id="tab1" aria-controls="equipmentType" <?php echo ($activeTab == 'tab1') ? 'checked' : ''; ?> onclick="setActiveTab('tab1', 'Equipment Type')">
        <label for="tab1">Equipment type</label>
        <!-- Tab 2 -->
        <input type="radio" name="tabset" id="tab2" aria-controls="equipmentCondition" <?php echo ($activeTab == 'tab2') ? 'checked' : ''; ?> onclick="setActiveTab('tab2', 'Equipment Condition')">
        <label for="tab2">Equipment condition</label>
        <!-- Tab 3 -->
        <input type="radio" name="tabset" id="tab3" aria-controls="equipmentStatus" <?php echo ($activeTab == 'tab3') ? 'checked' : ''; ?> onclick="setActiveTab('tab3', 'Equipment Status')">
        <label for="tab3">Equipment status</label>

        <div class="tab-panels">
            <section id="equipmentType" class="tab-panel">
                <!-- Call the table display -->
                 <?php  include("../manage-equipments-ref-data/EquipmentType/equipment-display.php"); ?>
            </section>
            
            <section id="equipmentCondition" class="tab-panel">
                <?php include("../manage-equipments-ref-data/EquipmentCondition/condition-display.php"); ?>
            </section>

            <section id="equipmentStatus" class="tab-panel">
                <?php include("../manage-equipments-ref-data/EquipmentStatus/status-display.php"); ?>
            </section>
        </div>
    </div>
</div>

<?php 
include("../templates/nav-bar2.php");
?>
</body>
</html>
