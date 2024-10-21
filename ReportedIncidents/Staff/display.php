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
    <!-- custom style -->
    <style>
        .tableDiv{
            font-family: 'Poppins', sans-serif;        
            font-size:10px;
        }
    </style>
    
    
</head>
<body>

    <?php 
    include("../../templates/nav-bar.php");
    ?>

    <!-- Scripts -->
    <!-- Note: It will not work inside header because of the php block for templates -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- data table -->
    <script src="/Styles/data-table/jquery-3.7.1.js"></script>
    <script src="/Styles/data-table/dataTables.js"></script>
    <link href="/Styles/data-table/dataTables.css" rel="stylesheet" />

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <div class="container">
        <div class="tabset">
            <!-- Table view tab -->
            <input type="radio" name="tabset" id="tab1" aria-controls="tableView" <?php echo ($activeTab == 'tab1') ? 'checked' : ''; ?> onclick="setActiveTab('tab1')">
            <label for="tab1" style="display: none">Table View</label>
            
            <!-- Insert new tab -->
            <input type="radio" name="tabset" id="addRecordView" aria-controls="addRecordView" <?php echo ($activeTab == 'addRecordView') ? 'checked' : ''; ?> onclick="setActiveTab('addRecordView')">
            <label for="addRecordView" style="display: none">Insert record</label>
            
            <!-- Update record tab -->
            <input type="radio" name="tabset" id="updateRecordView" aria-controls="updateRecordView" <?php echo ($activeTab == 'updateRecordView') ? 'checked' : ''; ?> onclick="setActiveTab('updateRecordView')">
            <label for="updateRecordView" style="display: none">Update Record</label>
            
            <!-- Map view tab -->
            <input type="radio" name="tabset" id="mapView" aria-controls="mapView" <?php echo ($activeTab == 'mapView') ? 'checked' : ''; ?> onclick="setActiveTab('mapView')">
            <label for="mapView" style="display: none">Maps</label>

            <!-- Full Details view tab -->
            <input type="radio" name="tabset" id="fullDetailsView" aria-controls="fullDetailsView" <?php echo ($activeTab == 'fullDetailsView') ? 'checked' : ''; ?> onclick="setActiveTab('fullDetailsView')">
            <label for="fullDetailsView" style="display: none">Maps</label>
            
            <div class="tab-panels">
                <section id="tableView" class="tab-panel">
                    <!-- Display of table view -->
                    <button  id="createNewButton">Create New</button>
                    <button id ="updateRecordButton" >Update record</button>

                    <div class="tableDiv">
                        <table id="incidentReportDataTable" class="display" style="width:100%; border:1px solid black; font-size=10px;" >
                            <thead style="text-align:center; " >
                            <tr>
                                <th style="width:10%;">ID</th>
                                <th>REPORT NUMBER</th>
                                <th>STATE</th>
                                <th>ASSIGNED BY</th>
                                <th>ASSIGNED TO</th>
                                <th>IS ACCEPTED?</th>
                                <th>DATE ASSIGNED</th>
                                <th>DATE REPORTED</th>
                                <th>REPORTED BY</th>
                                <th>CREATED BY</th>
                                <th>UPDATED BY</th>
                                <th>ACTIVITY DATE</th>
                                <th>DATE CREATED</th>
                                <th>LOCATION</th>
                                <th>LATITUDE</th>
                                <th>LONGITUDE</th>
                                <th>ACTIONS</th>
                            </tr>
                            </thead>
                            <tbody id="dataBody" style="text-align:center;">
                            </tbody>

                            <tfoot>
                                <tr>
                                <th style="width:10%;">ID</th>
                                <th>REPORT NUMBER</th>
                                <th>STATE</th>
                                <th>ASSIGNED BY</th>
                                <th>ASSIGNED TO</th>
                                <th>IS ACCEPTED?</th>
                                <th>DATE ASSIGNED</th>
                                <th>DATE REPORTED</th>
                                <th>REPORTED BY</th>
                                <th>CREATED BY</th>
                                <th>UPDATED BY</th>
                                <th>ACTIVITY DATE</th>
                                <th>DATE CREATED</th>
                                <th>LOCATION</th>
                                <th>LATITUDE</th>
                                <th>LONGITUDE</th>
                                <th>ACTIONS</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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

                <section id="fullDetailsView" class="tab-panel">
                    <!-- Manage Full Details view  -->
                     <h2>Fulldetails of Incident Rerorts</h2>
                    <button id="fullDetailsBackButton" >Back</button>
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
            function switchToFullDetailsTab() {
                setActiveTab('fullDetailsView'); 
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

            $('#fullDetailsBackButton').on('click', function() {
                console.log("Run AJAX logic for view details ");
                //refresh the table 
                switchToFirstTab();
            });

            //Dynamic Clickable Id 
            $(document).on('click', '.clickable-id', function() {
                var id = $(this).text();  
                console.log("Clicked ID: " + id);
                switchToFullDetailsTab();
                
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

            //DISPLAY OF DATA TABLE
            let tableData = [];
            let currentPage = 1;
            const pageSize = 5;

            new DataTable('#incidentReportDataTable', {
                initComplete: function () {
                    const api = this.api();
                    // Hide columns in a single operation
                    api.columns([
                        6, //date_assigned
                        7,//date_reported
                        8, //reported_by
                        9, //created_by
                        10, //updated_by
                        11, //activity_date
                        12, //created_on
                        13, //location
                        14, //coordinate_lat
                        15, //coordinate_lng
                        16 //illegal_activity_detail
                    ]).visible(false);

                    api.columns().every(function (index) { 
                        const column = this;
                        const footer = column.footer();
                        //disabling the footer search for action
                        if (index !== 16) { 
                            const input = document.createElement('input'); 
                            input.placeholder = column.footer().textContent;
                            if (footer) { 
                                footer.innerHTML = ''; 
                                footer.appendChild(input);

                                // Event listener for user input
                                input.addEventListener('keyup', debounce(() => {
                                    if (column.search() !== input.value) {
                                        column.search(input.value).draw();
                                    }
                                }, 300));
                            }
                        }
                    });
                }
            });

            // Debounce function to limit the rate at which the search is performed
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }      
            
            function fetchDataFromDB() {
                $.ajax({
                    url: '/ReportedIncidents/Staff/GET/get-record.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // console.log('Success:', response);
                        updateTable(response);//call updateTable
                    },
                    error: function(xhr, status, error) {
                        // console.error('Error:', error);
                        // console.log(xhr.messageText);
                        // console.log(xhr);
                    }
                });
            }

            function updateTable(data) {
    const table = $('#incidentReportDataTable').DataTable();
    table.clear(); // Clear the existing data from the DataTable

    data.forEach(rowData => {
        const rowDataArray = [];

        // Iterate over the object values to push each value to rowDataArray
        Object.values(rowData).forEach(value => {
            rowDataArray.push(value);
        });

        // Log the row data before appending action buttons
        console.log("Row data before adding action buttons:", rowDataArray);

        // Add action buttons as the last column
        rowDataArray.push(`
            <div class="dropdown">
                <button type="button" class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item edit-action" href="#" data-id="${rowData['id']}"> Edit <i class="bi bi-pencil-fill" style="float:right"></i></a></li>
                    <li><a class="dropdown-item delete-action" href="#" data-id="${rowData['id']}"> Delete <i class="bi bi-trash-fill" style="float:right"></i></a></li>
                </ul>
            </div>
        `);

        // Log the final row with the action buttons
        console.log("Final row data with action buttons:", rowDataArray);

        // Add the row to the DataTable
        table.row.add(rowDataArray);
    });

    table.order([12, 'desc']).draw(); // Redraw the DataTable
}



            // Call fetchDataFromDB()
            fetchDataFromDB();
        </script>
    <?php
    include "../../templates/nav-bar2.php"; 
    ?>

</body>
</html> 
