<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");
require("../../includes/authentication.php");

if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

// Get the active tab from session
$activeTab = isset($_SESSION['activeTab']) ? $_SESSION['activeTab'] : 'tab1';

// Correct the session tab logic to match HTML element IDs
if ($activeTab === 'tab2') {
    $activeTab = 'addRecordView'; // Adjust for actual ID
}

if ($activeTab === 'tab3') {
    $activeTab = 'updateRecordView'; // Adjust for actual ID
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Item Monitoring</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/Styles/reported-incidents-staff-tab.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>

    <?php 
    include("../../templates/nav-bar.php");
    ?>

    <div class="container">
        <div class="tabset">
            <!-- Table view tab -->
            <input type="radio" name="tabset" id="tab1" aria-controls="tableView" <?php echo ($activeTab == 'tab1') ? 'checked' : ''; ?> onclick="setActiveTab('tab1')">
            <label for="tab1">Table View</label>

            <!-- Insert new tab -->
            <input type="radio" name="tabset" id="addRecordView" aria-controls="addRecordView" <?php echo ($activeTab == 'addRecordView') ? 'checked' : ''; ?> onclick="setActiveTab('addRecordView')">
            <label for="addRecordView">Insert record</label>

            <!-- Update record tab -->
            <input type="radio" name="tabset" id="updateRecordView" aria-controls="updateRecordView" <?php echo ($activeTab == 'updateRecordView') ? 'checked' : ''; ?> onclick="setActiveTab('updateRecordView')">
            <label for="updateRecordView">Update Record</label>

            <!-- Map view tab -->
            <input type="radio" name="tabset" id="mapView" aria-controls="mapView" <?php echo ($activeTab == 'mapView') ? 'checked' : ''; ?> onclick="setActiveTab('mapView')">
            <label for="mapView">Maps</label>

            <div class="tab-panels">
                <section id="tableView" class="tab-panel">
                    <!-- Display of table view -->
                    <button  id="createNewButton">Create New</button>
                    <button id ="updateRecordButton" >Update record</button>
                </section>

                <section id="addRecordView" class="tab-panel">
                    <!-- Manage Insert -->
                    <button id="submitButton">Submit</button>
                    <button id="addCoordinatesButton" >Add coordinates</button>
                </section>

                <section id="updateRecordView" class="tab-panel">
                    <!-- Manage Update record -->
                    <button id="saveUpdateButton" >Save</button>
                </section>

                <section id="mapView" class="tab-panel">
                    <!-- Manage Map view -->
                    <button id="doneMapButton" >Done</button>
                </section>
            </div>
        </div>
    </div>
        <script>
            // Set the active tab via AJAX
            function setActiveTab(tabId) {
                $.ajax({
                    url: '/monitor-item-set-active.php',
                    type: 'POST',
                    data: { activeTab: tabId },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            // console.log("Active tab updated successfully");
                            
                            document.getElementById(tabId).checked = true; // Ensure the tab is checked
                            
                        } else {
                            console.error("Failed to update active tab: " + res.message);
                        }
                    },
                    error: function() {
                        console.error("An error occurred while updating the active tab");
                    }
                });
            }

            function switchToFourthTab() {
                setActiveTab('mapView'); 
            }
            
            function switchToThirdTab() {
                setActiveTab('updateRecordView'); 
            }
            
            function switchToSecondTab(tabId) {
                setActiveTab('addRecordView'); 
            }

            function switchToFirstTab() {
                setActiveTab('tab1'); 
            }

            // button click functions
            $('#createNewButton').on('click', function() {
                switchToSecondTab();
            });

            $('#updateRecordButton').on('click', function() {
                switchToThirdTab();
            });

            $('#submitButton').on('click', function() {
                console.log("run the Ajax logic for submiting the record");
                switchToFirstTab();
            });

            $('#addCoordinatesButton').on('click', function() {
                switchToFourthTab();
            });

            $('#saveUpdateButton').on('click', function() {
                // Run AJAX logic for update
                console.log("Run AJAX logic for update");
                //refresh the table 
                switchToFirstTab();
            });

            $('#doneMapButton').on('click', function() {
                // Run AJAX logic for Insert map coordinates
                console.log("Run AJAX logic for Insert map coordinates");
                //refresh the table 
                switchToFirstTab();
            });

            // Set the active tab on page load based on the session value
            document.addEventListener('DOMContentLoaded', function() {
                var activeTabId = '<?php echo $activeTab; ?>';
                var activeTabElement = document.getElementById(activeTabId);

                if (activeTabElement) {
                    activeTabElement.checked = true;
                } else {
                    console.error("Element with ID " + activeTabId + " not found");
                }
            });
        </script>
    <?php
    include "../../templates/nav-bar2.php"; 
    ?>

</body>
</html> 
