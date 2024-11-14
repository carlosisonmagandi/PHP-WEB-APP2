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

$activeTab = isset($_SESSION['activeTab']) ? $_SESSION['activeTab'] : 'tab1';

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
        /* .actionButton{
            background-color: #FFF;
            border:none;
            width: 100%;
            text-align:left;
            color:#002f6c;
            font-size:12px;
        }
        .actionButton:hover{
            background-color:#002f6c;
            color:#FFF;
        } */
        .back-to-list{
            background-color: transparent;
            color: #002f6c;
            border: none;
            padding: 6px;
            font-size: 18px;
            border-bottom: 2px solid #002f6c; 
            padding-bottom: 4px;
            float:right;
        }
        /* Custom action button */
        #updateButton{
            border:none;
            width: 100%;
            text-align:left;
            font-size:12px;
            color: #fff;
            background-color:#ffc107;
        }
        #updateButton:hover{
            background-color:#e0a800;
        }
        #deleteButton{
            border:none;
            width: 100%;
            text-align:left;
            font-size:12px;
            color: #fff;
            background-color:#dc3545;
        }
        #deleteButton:hover{
            background-color:#c82333;
        }

        .button-container {
            display: flex;
            gap: 8px; 
            justify-content: flex-start; 
        }

        .actionButton {
            padding: 8px 8px;
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .actionButton i {
            margin-right: 5px; 
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet"> -->
    <div class="container">
        <div class="tabset">
            <!-- Table view tab -->
            <input type="radio" name="tabset" id="tab1" aria-controls="tableView" <?php echo ($activeTab == 'tab1') ? 'checked' : ''; ?> onclick="setActiveTab('tab1')">
            <label for="tab1" style="display:none">Table View</label>
            
            <!-- Insert new tab -->
            <input type="radio" name="tabset" id="addRecordView" aria-controls="addRecordView" <?php echo ($activeTab == 'addRecordView') ? 'checked' : ''; ?> onclick="setActiveTab('addRecordView')">
            <label for="addRecordView" style="display:none">Insert record</label>
            
            <!-- Update record tab -->
            <input type="radio" name="tabset" id="updateRecordView" aria-controls="updateRecordView" <?php echo ($activeTab == 'updateRecordView') ? 'checked' : ''; ?> onclick="setActiveTab('updateRecordView')">
            <label for="updateRecordView" style="display:none">Update Record</label>
            
            <!-- Map view tab -->
            <input type="radio" name="tabset" id="mapView" aria-controls="mapView" <?php echo ($activeTab == 'mapView') ? 'checked' : ''; ?> onclick="setActiveTab('mapView')">
            <label for="mapView" style="display:none">Maps</label>

            <!-- Full Details view tab -->
            <input type="radio" name="tabset" id="fullDetailsView" aria-controls="fullDetailsView" <?php echo ($activeTab == 'fullDetailsView') ? 'checked' : ''; ?> onclick="setActiveTab('fullDetailsView')">
            <label for="fullDetailsView" style="display:none">Fulldetails</label>
            
            <!-- Update Maps view tab -->
            <input type="radio" name="tabset" id="updateMapsView" aria-controls="updateMapsView" <?php echo ($activeTab == 'updateMapsView') ? 'checked' : ''; ?> onclick="setActiveTab('updateMapsView')">
            <label for="updateMapsView" style="display:none">Update Maps</label>

            <div class="tab-panels">
                <section id="tableView" class="tab-panel">
                    <!-- Display of table view -->
                    <button  id="createNewButton" class="btn btn-primary">Create New</button>
                    <!-- <button id ="updateRecordButton" >Update record</button> -->

                    <div class="tableDiv">
                        <table id="incidentReportDataTable" class="display" style="width:100%; border:1px solid black; font-size=10px;" >
                            <thead style="text-align:center;">
                            <tr>
                            <th style="width:10%;">ID</th>
                                <th>REPORT NUMBER</th>
                                <th>STATE</th>
                                <!-- <th>ASSIGNED BY</th> -->
                                <th>ASSIGNED TO</th>
                                <th>IS ACCEPTED?</th>
                                <!-- <th>DATE ASSIGNED</th> -->
                                <!-- <th>DATE REPORTED</th> -->
                                <th>REPORTED BY</th>
                                <!-- <th>CREATED BY</th>
                                <th>UPDATED BY</th>
                                <th>ACTIVITY DATE</th>
                                <th>DATE CREATED</th>
                                <th>LOCATION</th>
                                <th>LATITUDE</th>
                                <th>LONGITUDE</th> -->
                                <th>DETAILS</th>
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
                                <!-- <th>ASSIGNED BY</th> -->
                                <th>ASSIGNED TO</th>
                                <th>IS ACCEPTED?</th>
                                <!-- <th>DATE ASSIGNED</th> -->
                                <!-- <th>DATE REPORTED</th> -->
                                <th>REPORTED BY</th>
                                <!-- <th>CREATED BY</th>
                                <th>UPDATED BY</th>
                                <th>ACTIVITY DATE</th>
                                <th>DATE CREATED</th>
                                <th>LOCATION</th>
                                <th>LATITUDE</th>
                                <th>LONGITUDE</th> -->
                                <th>DETAILS</th>
                                <th>ACTIONS</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>

                <section id="addRecordView" class="tab-panel">
                    <!-- Manage Insert -->
                    <!-- <form> -->
                     <div class="form-group">
                            <button class="back-to-list" id="backToList">Back to List</button>
                            <br><br>
                            <h2> Create New </h2>
                            <table style="width:100%;">
                                
                                <!-- Report Number -->
                                <tr>
                                    <td>
                                        <label for="createNewReportedNumber">Report Number:</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="createNewReportedNumber" name="createNewReportedNumber" disabled >
                                    </td>
                                </tr>
                                <!-- State -->
                                <tr>
                                    <td>
                                        <label for="state">State:</label>
                                    </td>
                                    <td>
                                        <!-- <input type="text" class="form-control" id="state" name="state" > -->
                                        <select class="form-control" id="createNewState" name="createNewState">
                                            <option value="Open">Open</option>
                                            <option value="Assigned">Assigned</option>   
                                        </select>
                                    </td>
                                </tr>
                                <!-- Assigned to -->
                                <tr>
                                    <td>
                                        <label for="createNewAssignedTo">Assign to:</label>
                                    </td>
                                    <td>
                                        <!-- <input type="text" class="form-control" id="assignedTo" name="assignedTo" > -->
                                        <select class="form-control" id="createNewAssignedTo" name="createNewAssignedTo">
                                            <!-- Options will be populated by JavaScript -->
                                        </select>
                                    </td>
                                </tr>
                                <!-- is accepted -->
                                <!-- <tr>
                                    <td>
                                        <label for="createNewIsAccepted">Is Accepted?</label>
                                    </td>
                                    <td>
                                        <select class="form-control" id="createNewIsAccepted" name="createNewIsAccepted">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr> -->

                                <!-- Reported by -->
                                <tr>
                                    <td>
                                        <label for="createNewReportedBy">Reported By</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="createNewReportedBy" name="createNewReportedBy" >
                                    </td>
                                </tr>
                                <!-- Reported Date -->
                                <tr>
                                    <td>
                                        <label for="createNewReportedDate">Date Reported</label>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" id="createNewReportedDate" name="createNewReportedDate" >
                                    </td>
                                </tr>
                                <!-- Location -->
                                 <tr>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success" id="addLocationGeoTagBtn">
                                            <i class="fas fa-map-marker" ></i> Add Location
                                        </button>
                                    </td>
                                 </tr>
                                <tr>
                                    <td>
                                        <label for="createNewLocation">Location</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="createNewLocation" name="createNewLocation" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Coordinates</td>
                                    <td>
                                        <div>
                                            <input disabled id="createNewCoordinateLng" name="createNewCoordinateLng"  type="text" placeholder="Enter Longitude">

                                            <input disabled id="createNewCoordinateLat" name="createNewCoordinateLat"  type="text" placeholder="Enter Latitude">
                                        </div>
                                    </td>
                                </tr>
                                <!-- Details -->
                                <tr>
                                    <td>
                                        <label for="createNewDetails">Details</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="createNewDetails" name="createNewDetails" required>
                                    </td>
                                </tr>
                                
                            </table>                              
                        </div>
                        <button id="submitButton" class="btn btn-primary" style="float:right;margin-top:20px">Submit</button>
                        <!-- <button id="setLocationButton" >Set Location</button> -->
                    <!-- </form> -->
                    
                </section>

                <section id="updateRecordView" class="tab-panel">
                    <!-- Manage Update record -->
                    <!-- <form> -->
                        <div class="form-group">
                            <button class="back-to-list" id="backToListFromUpdate">Back to List</button>
                            <br><br>
                            <h2>Edit Details</h2>
                            <table style="width:100%">
                                <tr>
                                    <td>
                                        <label for="reportedId">ID:</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="reportedId" name="reportedId" disabled >
                                    </td>
                                </tr>
                                <!-- Report Number -->
                                <tr>
                                    <td>
                                        <label for="reportedNumber">Report Number:</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="reportedNumber" name="reportedNumber" disabled >
                                    </td>
                                </tr>
                                <!-- State -->
                                <tr>
                                    <td>
                                        <label for="state">State:</label>
                                    </td>
                                    <td>
                                        <!-- <input type="text" class="form-control" id="state" name="state" > -->
                                        <select class="form-control" id="state" name="state">
                                            <option value="Open">Open</option>
                                            <option value="Assigned">Assigned</option>   
                                        </select>
                                    </td>
                                </tr>
                                <!-- Assigned to -->
                                <tr>
                                    <td>
                                        <label for="assignedTo">Assign to:</label>
                                    </td>
                                    <td>
                                        <!-- <input type="text" class="form-control" id="assignedTo" name="assignedTo" > -->
                                        <select class="form-control" id="assignedTo" name="assignedTo">
                                            <!-- Options will be populated by JavaScript -->
                                        </select>
                                    </td>
                                </tr>
                                <!-- is accepted -->
                                <tr>
                                    <td>
                                        <label for="isAccepted">Is Accepted?</label>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" id="isAccepted" name="isAccepted" disabled >
                                    </td>
                                </tr>

                                <!-- Reported by -->
                                <tr>
                                    <td>
                                        <label for="reportedBy">Reported By</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="reportedBy" name="reportedBy" >
                                    </td>
                                </tr>
                                <!-- Location -->
                                <tr>
                                    <td>
                                        <label for="location">Location</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="location" name="location" >
                                    </td>
                                </tr>
                                <!-- Details -->
                                <tr>
                                    <td>
                                        <label for="details">Details</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="details" name="details" >
                                    </td>
                                </tr>
                                <!-- Coordinates -->
                                <tr>
                                    <td>
                                        <label for="details">Coordinates</label>
                                    </td>
                                    <td>
                                        Longitude: <input type="text" class="form-control" id="coordinate_lng_from_put" name="coordinate_lng_from_put" >
                                        Latitude: <input type="text" class="form-control" id="coordinate_lat_from_put" name="coordinate_lat_from_put" >
                                    </td>
                                    
                                </tr>
                            </table>                              
                        </div>

                        <button id="saveUpdateButton" >Save</button>
                        <!-- <button id="updateMapsButton" >Update Maps</button> -->
                    <!-- </form> -->
                </section>

                <section id="mapView" class="tab-panel">
                    <!-- Manage Map view -->
                    <button id="doneMapButton" >Done</button>
                    <button id="addCoordinatesButton" >Add Coordinates</button>
                    <div id="mapViewContainer"></div>
                    
                </section>

                <section id="fullDetailsView" class="tab-panel">
                    <!-- Manage Full Details view  -->
                     <div >
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><strong>ID</strong></td>
                                    <td id="id"></td>
                                </tr>
                                <tr>
                                    <td><strong>Report Number</strong></td>
                                    <td id="report_number"></td>
                                </tr>
                                <tr>
                                    <td><strong>Illegal Activity Detail</strong></td>
                                    <td id="illegal_activity_detail"></td>
                                </tr>
                                <tr>
                                    <td><strong>State</strong></td>
                                    <td id="data_state"></td>
                                </tr>
                                <tr>
                                    <td><strong>Reported By</strong></td>
                                    <td id="reported_by"></td>
                                </tr>
                                <tr>
                                    <td><strong>Date Reported</strong></td>
                                    <td id="date_reported"></td>
                                </tr>
                                <tr>
                                    <td><strong>Assigned By</strong></td>
                                    <td id="assigned_by"></td>
                                </tr>
                                <tr>
                                    <td><strong>Assigned To</strong></td>
                                    <td id="assigned_to"></td>
                                </tr>
                                <tr>
                                    <td><strong>Is Accepted?</strong></td>
                                    <td id="data_isAccepted"></td>
                                </tr>
                                <tr>
                                    <td><strong>Date Assigned</strong></td>
                                    <td id="date_assigned"></td>
                                </tr>
                                <tr>
                                    <td><strong>Location</strong></td>
                                    <td id="data_location"></td>
                                </tr>
                                <tr>
                                    <td><strong>Coordinate Lat</strong></td>
                                    <td id="coordinate_lat_from_get"></td>
                                </tr>
                                <tr>
                                    <td><strong>Coordinate Lng</strong></td>
                                    <td id="coordinate_lng_from_get"></td>
                                </tr>
                                <tr>
                                    <td><strong>Activity Date</strong></td>
                                    <td id="activity_date"></td>
                                </tr>
                                <tr>
                                    <td><strong>Created By</strong></td>
                                    <td id="created_by"></td>
                                </tr>
                                <tr>
                                    <td><strong>Created On</strong></td>
                                    <td id="created_on"></td>
                                </tr>  
                            </tbody>
                        </table>
                    </div>

                    <button id="fullDetailsBackButton" >Back</button>
                </section>

                <!-- Update maps view section -->
                <section id="updateMapsVIew" class="tab-panel">
                    test map view section
                </section>
            </div>
        </div>
    </div>
        <script>
            //DISPLAY OF DATA TABLE
            
            $('#incidentReportDataTable').DataTable({
                "order": [[ 12, "desc" ]],//order based on the latest created record
                "responsive": true,
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50]
            });
            
            function fetchDataFromDB() {
                $.ajax({
                    url: '/ReportedIncidents/Staff/GET/get-record.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var table = $('#incidentReportDataTable').DataTable();
                        table.clear();
                        
                        var rows = [];
                        $.each(response, function(index, row) {
                            var actionButtons = `
                                <div class="button-container">
                                    <button class="actionButton" id="updateButton" onclick="switchToThirdTab(${row.id})">
                                        <i class="fas fa-edit"></i>&nbspEdit
                                    </button>
                                    <button class="actionButton" id="deleteButton" onclick="deleteRecord(${row.id})">
                                        <i class="fas fa-trash-alt"></i>&nbspDelete
                                    </button>
                                </div>

                                

                            `;
                            var clickableId = '<a class="clickable-id" data-id="' + row.id + '">' + row.id + '</a>';

                            rows.push([
                                clickableId,
                                row.report_number,
                                row.state,
                                row.assigned_to,
                                row.isAccepted,
                                row.reported_by,
                                row.illegal_activity_detail,
                                actionButtons
                            ]);
                        });

                        table.rows.add(rows).draw();
                        table.order([0, 'desc']).draw();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert("Error fetching data. See console for details.");
                    }
                });
            }
            // Call fetchDataFromDB()
            fetchDataFromDB();

            // Set the active tab via AJAX
            function setActiveTab(tabId) {
                $.ajax({
                    url: '/monitor-item-set-active.php',
                    type: 'POST',
                    data: { activeTab: tabId },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            
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
            
            function switchToThirdTab(id) {
                setActiveTab('updateRecordView');

                //set value for action button
                sessionStorage.setItem('actionButton', 'updateDetails');
                const actionButton = sessionStorage.getItem('actionButton');
                // console.log("action is:",actionButton);
                
                if (id) {
                    
                    $.ajax({
                        url: '/ReportedIncidents/Staff/GET/get-record-by-id.php',
                        type: 'GET',
                        data: { reported_id: id },
                        dataType: 'json',   
                        success: function(data) {
                            if (data.status === 'success') {
                                getAccountByFieldStaff();//call function to display the fullname based on session value

                                let record = data.data;
                                $('#reportedId').val(record.id);
                                $('#reportedNumber').val(record.report_number);
                                $('#state').val(record.state);
                                $('#assignedTo').val(record.assigned_to);
                                $('#isAccepted').val(record.isAccepted);
                                $('#reportedBy').val(record.reported_by);
                                $('#location').val(record.location);
                                $('#details').val(record.illegal_activity_detail);
                                $('#coordinate_lat_from_put').val(record.coordinate_lat);
                                $('#coordinate_lng_from_put').val(record.coordinate_lng);

                                // Store the value in sessionStorage
                                sessionStorage.setItem('reportedId', record.id);
                                sessionStorage.setItem('reportedNumber', record.report_number);
                                sessionStorage.setItem('state', record.state);
                                sessionStorage.setItem('assignedTo', record.assigned_to);
                                sessionStorage.setItem('isAccepted', record.isAccepted);
                                sessionStorage.setItem('reportedBy', record.reported_by);
                                sessionStorage.setItem('location', record.location);
                                sessionStorage.setItem('details', record.illegal_activity_detail);
                                sessionStorage.setItem('coordinate_lat_from_put', record.coordinate_lat);
                                sessionStorage.setItem('coordinate_lng_from_put', record.coordinate_lng);
                            } else {
                                Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                        }
                    });
                }
            }

            // Retrieve the value from sessionStorage on page load
            $(document).ready(function() {
            
                const actionButton=sessionStorage.getItem('actionButton');
                if(actionButton==='updateDetails'){
                    getAccountByFieldStaff();
                    const savedId = sessionStorage.getItem('reportedId');
                    const savedNumber = sessionStorage.getItem('reportedNumber');
                    const state = sessionStorage.getItem('state');
                    const assignedTo = sessionStorage.getItem('assignedTo');
                    const isAccepted = sessionStorage.getItem('isAccepted');
                    const reportedBy = sessionStorage.getItem('reportedBy');
                    const location = sessionStorage.getItem('location');
                    const details = sessionStorage.getItem('details');
                    const coordinate_lng= sessionStorage.getItem('coordinate_lng_from_put');
                    const coordinate_lat= sessionStorage.getItem('coordinate_lat_from_put');

                    if (savedId && savedNumber && state && assignedTo && isAccepted && reportedBy && location && details && coordinate_lng && coordinate_lat) {
                        $('#reportedId').val(savedId);
                        $('#reportedNumber').val(savedNumber);
                        $('#state').val(state);
                        $('#assignedTo').val(assignedTo);
                        $('#isAccepted').val(isAccepted);
                        $('#reportedBy').val(reportedBy);
                        $('#location').val(location);
                        $('#details').val(details);
                        $('#coordinate_lng_from_put').val(coordinate_lng);
                        $('#coordinate_lat_from_put').val(coordinate_lat);
                    }
                }else if(actionButton=='fulldetails'){
                    // console.log('call session function for full details view');
                    getSessionFullDetails();
                }else if (actionButton==='createNew'){
                    createNewGetAccountByFieldStaff();
                }
                
            });

            //Display fullname on dropwdown menu (UPDATE view)
            function getAccountByFieldStaff(){
                $.ajax({
                    url: '/ReportedIncidents/Staff/GET/get-account.php',
                    type: 'POST',
                    success: function(response) {
                        var assignedToDropdown = $('#assignedTo');
                        assignedToDropdown.empty();

                        if (!id) {
                            assignedToDropdown.append('<option value="">Select Field Staff</option>');
                        } else {
                            // Retrieve from session storage if available
                            let field_staff_session = sessionStorage.getItem('assignedTo');
                            if (field_staff_session) {
                                assignedToDropdown.append('<option selected value="' + field_staff_session + '">' + field_staff_session + '</option>');
                            }
                        }

                        // Iterate through the response data (array of accounts)
                        $.each(response, function(index, fieldStaff) {
                            var fullName = fieldStaff.full_name;
                            if (!assignedToDropdown.find('option[value="' + fullName + '"]').length) {
                                assignedToDropdown.append('<option value="' + fullName + '">' + fullName + '</option>');
                            }
                        });
                    },
                    error: function() {
                        console.error("An error occurred ");
                    }
                });
            }

            //Display fullname on dropdown menu(Create new VIEW)
            function createNewGetAccountByFieldStaff(){
                $.ajax({
                    url: '/ReportedIncidents/Staff/GET/get-account.php',
                    type: 'POST',
                    success: function(response) {
                        var assignedToDropdown = $('#createNewAssignedTo');
                        assignedToDropdown.empty();

                        if (!id) {
                            assignedToDropdown.append('<option value="">Select Field Staff</option>');
                        } else {
                            // Retrieve from session storage if available
                            let field_staff_session = sessionStorage.getItem('assignedTo');
                            if (field_staff_session) {
                                assignedToDropdown.append('<option selected value="' + field_staff_session + '">' + field_staff_session + '</option>');
                            }
                        }

                        // Iterate through the response data (array of accounts)
                        $.each(response, function(index, fieldStaff) {
                            var fullName = fieldStaff.full_name;
                            if (!assignedToDropdown.find('option[value="' + fullName + '"]').length) {
                                assignedToDropdown.append('<option value="' + fullName + '">' + fullName + '</option>');
                            }
                        });
                    },
                    error: function() {
                        console.error("An error occurred ");
                    }
                });
            }

            //switching logic 
            function switchToSecondTab(tabId) {
                setActiveTab('addRecordView'); 
            }

            function switchToFirstTab() {
                setActiveTab('tab1'); 
            }
            function switchToFullDetailsTab() {
                setActiveTab('fullDetailsView'); 
            }
            function switchToUpdateMapsTab() {
                setActiveTab('updateMapsView'); 
            }


            // button click functions
            $('#createNewButton').on('click', function() {
                sessionStorage.setItem('actionButton', 'createNew');
                // const actionButton = sessionStorage.getItem('actionButton');
                // console.log("action is:",actionButton);
                switchToSecondTab();// Switch to Create New record View 
                createNewGetAccountByFieldStaff();//Call the drop 

            });

            // delete button
            function deleteRecord(id) {
                sessionStorage.setItem('actionButton', 'deleteRecord');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = {
                            id: id
                        };

                        $.ajax({
                            url: '/ReportedIncidents/Staff/DELETE/delete-record.php',
                            type: 'DELETE',
                            contentType: 'application/json',
                            data: JSON.stringify(data),
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire('Deleted!', 'The record has been deleted successfully.', 'success').then(() => {
                                        fetchDataFromDB();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message || 'An error occurred while deleting the record.', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');
                            }
                        });
                    }
                });

            };

            // $('#updateRecordButton').on('click', function() {
            //     switchToThirdTab();
            // });

            //Geotag button 
            const geoTagButton = document.getElementById('addLocationGeoTagBtn');
            if (geoTagButton) {
                let swalInstance;  
                geoTagButton.addEventListener('click', function() {
                    swalInstance = Swal.fire({
                        html: `
                            <iframe src="/geo-tag.php" width="100%" height="90%" scrolling="no" style="object-fit: cover; overflow:hidden"></iframe>
                            <input type="button" value="Set Coordinate" id="saveCoordinateButton">
                        `,
                        showConfirmButton: false,
                        willOpen: () => {
                            document.querySelector('.swal2-popup').style.height = '400px';
                        }
                    });

                    let latitude, longitude, address;

                    // Listen for the coordinates from the iframe
                    window.addEventListener('message', function(event) {
                        if (event.origin === window.location.origin) { 
                            const { latitude: lat, longitude: lon, address: addr } = event.data;
                            if (lat && lon && addr) {
                                latitude = lat;
                                longitude = lon;
                                address = addr;
                            }
                        }
                    });

                    document.addEventListener('click', function(event) {
                        if (event.target && event.target.id === 'saveCoordinateButton') {
                            // Only assign values if we have received coordinates and address
                            if (latitude && longitude && address) {
                                document.getElementById('createNewCoordinateLat').value = latitude;
                                document.getElementById('createNewCoordinateLng').value = longitude;
                                document.getElementById('createNewLocation').value = address;

                                swalInstance.close();
                            } else {
                                console.log('No coordinates or address yet');
                            }
                        }
                    });
                });
            }

            $('#submitButton').on('click', function() {
                const dateReported = $('#createNewReportedDate').val();
                
                const today = new Date();
                const selectedDate = new Date(dateReported);

                today.setHours(0, 0, 0, 0);
                selectedDate.setHours(0, 0, 0, 0);
                
                if (selectedDate > today) {
                    Swal.fire('Invalid Date!', 'The date cannot be in the future.', 'error');
                    return;  
                }

                const data = {
                    action: 'insert_record',
                    state: $('#createNewState').val(),
                    assignedTo: $('#createNewAssignedTo').val(),
                    reportedBy: $('#createNewReportedBy').val(),
                    location: $('#createNewLocation').val(),
                    date_reported: dateReported,
                    details: $('#createNewDetails').val(),
                    coordinate_lat: $('#createNewCoordinateLat').val(),
                    coordinate_lng: $('#createNewCoordinateLng').val()
                };

                const labels = {
                    state: 'State',
                    assignedTo: 'Assigned To',
                    reportedBy: 'Reported By',
                    location: 'Location',
                    details: 'Details',
                    date_reported: 'Date Reported',
                    coordinate_lat: 'Latitude',
                    coordinate_lng: 'Longitude',
                };

                for (let key in data) {
                    if (data[key] === '' || data[key] === null) {
                        Swal.fire(`${labels[key]} is required!`, 'Please complete the field.', 'info');
                        return;
                    }
                }

                $.ajax({
                    url: '/ReportedIncidents/Staff/POST/insert-record.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: 'json',
                    success: function(response) {
                        // console.log('Response received:', response);
                        if (response.status === 'success') {
                            $('#createNewState').val('');
                            $('#createNewAssignedTo').val('');
                            $('#createNewReportedBy').val('');
                            $('#createNewLocation').val('');
                            $('#createNewReportedDate').val('');
                            $('#createNewDetails').val('');
                            $('#createNewCoordinateLat').val('');
                            $('#createNewCoordinateLng').val('');
                            Swal.fire('Success!', 'Your record has been added successfully.', 'success').then(() => {
                                fetchDataFromDB();
                            });
                        } else {
                            Swal.fire('Error!', response.message || 'An error occurred while inserting the record.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred while inserting new record.', 'error');
                    }
                });

                switchToFirstTab();
            });


            //Create New- back to list button action
            $('#backToList').on('click', function() {
                switchToFirstTab();
            });
            
            $('#setLocationButton').on('click', function() {
                //switchToFourthTab();//Switch to Map view
                
         
            });

            // Update actions-------------------------------------------------------------------------------------------------
            $('#backToListFromUpdate').on('click', function() {
                switchToFirstTab();
            });

            $('#saveUpdateButton').on('click', function() {
                clearSessionData();
                // Run AJAX logic for update
                const savedId = sessionStorage.getItem('reportedId');
                // console.log("Record id:",savedId);
                // console.log("Run AJAX logic for update");

                const formData = new FormData();
                formData.append('action', 'update_record');
                formData.append('id', savedId);
                formData.append('state', $('#state').val());
                formData.append('isAccepted', $('#isAccepted').val());
                formData.append('assignedTo', $('#assignedTo').val());
                formData.append('reportedBy', $('#reportedBy').val());
                formData.append('location', $('#location').val());
                formData.append('details', $('#details').val());
                formData.append('coordinate_lng', $('#coordinate_lng_from_put').val());
                formData.append('coordinate_lat', $('#coordinate_lat_from_put').val());
                
                $.ajax({
                    url: '/ReportedIncidents/Staff/PUT/update-record.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        //console.log('Response received:', response);
                        if (response.status === 'success') {
                            const { id, state, assignedTo, isAccepted, reportedBy, location, details, date_assigned, updated_by, coordinate_lat, coordinate_lng } = response.data;
                            // console.log('ID:', id);

                            Swal.fire('Success!', 'Your record has been updated successfully.', 'success').then(() => {
                                fetchDataFromDB();
                            });
                        } else {
                            Swal.fire('Error!', response.message || 'An error occurred while updating the record.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred while updating the record.', 'error');
                    }
                });
                //refresh the table 
                switchToFirstTab();
            });

            $('#updateMapsButton').on('click', function() {
                switchToUpdateMapsTab();
            });

            $('#doneMapButton').on('click', function() {
                // Run AJAX logic for Insert map coordinates
                // console.log("Run AJAX logic for Insert map coordinates");
                //refresh the table 
                switchToSecondTab();
            });

            $('#fullDetailsBackButton').on('click', function() {
                clearFullDetailsSessionData();
                //refresh the table     
                switchToFirstTab();
            });

            //Dynamic Clickable Id 
            $(document).on('click', '.clickable-id', function() {
                //set value for action button
                sessionStorage.setItem('actionButton', 'fulldetails');
                const actionButton = sessionStorage.getItem('actionButton');
                // console.log("action is:",actionButton);
                var id = $(this).text();
                if (id) {
                    $.ajax({
                        url: '/ReportedIncidents/Staff/GET/get-record-by-id.php',
                        type: 'GET',
                        data: { reported_id: id },
                        dataType: 'json',
                        success: function(data) {
                            window.location.href = "/ReportedIncidents/Staff/display.php";

                            if (data.status === 'success') {
                                let record = data.data;
                                // Populate HTML with AJAX response data
                                const keyMapping = {
                                    'isAccepted': 'data_isAccepted',
                                    'location': 'data_location',
                                    'state': 'data_state'
                                };
                                //set sessions
                                sessionStorage.setItem('id', record.id);
                                sessionStorage.setItem('activity_date', record.activity_date);
                                sessionStorage.setItem('assigned_by', record.assigned_by);
                                sessionStorage.setItem('assigned_to', record.assigned_to);
                                sessionStorage.setItem('coordinate_lat_from_get', record.coordinate_lat);
                                sessionStorage.setItem('coordinate_lng_from_get', record.coordinate_lng);
                                sessionStorage.setItem('created_by', record.created_by);
                                sessionStorage.setItem('created_on', record.created_on);
                                sessionStorage.setItem('date_assigned', record.date_assigned);
                                sessionStorage.setItem('date_reported', record.date_reported);
                                sessionStorage.setItem('illegal_activity_detail', record.illegal_activity_detail);
                                sessionStorage.setItem('isAccepted', record.isAccepted);
                                sessionStorage.setItem('location', record.location);
                                sessionStorage.setItem('report_number', record.report_number);
                                sessionStorage.setItem('reported_by', record.reported_by);
                                sessionStorage.setItem('state', record.state);
                                sessionStorage.setItem('updated_by', record.updated_by);
                                
                                
                                // Populate HTML with AJAX response data
                                Object.keys(record).forEach(key => {
                                    let mappedKey = keyMapping[key] || key; // Use mapped ID if exists
                                    let element = document.getElementById(mappedKey);
                                    if (element) {
                                        element.textContent = record[key] || ''; // Safely set content
                                    }
                                });
                            } else {
                                Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                        }
                    });
                }
                switchToFullDetailsTab();
            });
            //clear details view session
            function clearFullDetailsSessionData(){
                sessionStorage.removeItem('actionButton');
                sessionStorage.removeItem('id');
                sessionStorage.removeItem('activity_date');
                sessionStorage.removeItem('assigned_by');
                sessionStorage.removeItem('assigned_to');
                sessionStorage.removeItem('coordinate_lat_from_get');
                sessionStorage.removeItem('coordinate_lng_from_get');
                sessionStorage.removeItem('created_by');
                sessionStorage.removeItem('created_on');
                sessionStorage.removeItem('date_assigned');
                sessionStorage.removeItem('date_reported');
                sessionStorage.removeItem('illegal_activity_detail');
                sessionStorage.removeItem('isAccepted');
                sessionStorage.removeItem('location');
                sessionStorage.removeItem('report_number');
                sessionStorage.removeItem('reported_by');
                sessionStorage.removeItem('state');
                sessionStorage.removeItem('updated_by');

            }
            //Full details view get session value
            function getSessionFullDetails() {
                
                    const id = sessionStorage.getItem('id');
                    const report_number = sessionStorage.getItem('report_number');
                    const illegal_activity_detail = sessionStorage.getItem('illegal_activity_detail');
                    const data_state = sessionStorage.getItem('state');
                    const reported_by = sessionStorage.getItem('reported_by');
                    const date_reported = sessionStorage.getItem('date_reported');
                    const assigned_by = sessionStorage.getItem('assigned_by');
                    const assigned_to = sessionStorage.getItem('assigned_to');
                    const data_isAccepted = sessionStorage.getItem('isAccepted');
                    const date_assigned = sessionStorage.getItem('date_assigned');
                    const data_location = sessionStorage.getItem('location');
                    const coordinate_lat = sessionStorage.getItem('coordinate_lat_from_get');
                    const coordinate_lng = sessionStorage.getItem('coordinate_lng_from_get');
                    const activity_date = sessionStorage.getItem('activity_date');
                    const created_by = sessionStorage.getItem('created_by');
                    const created_on = sessionStorage.getItem('created_on');
                    
                    $('#id').text(id);
                    $('#report_number').text(report_number);
                    $('#illegal_activity_detail').text(illegal_activity_detail);
                    $('#data_state').text(data_state);
                    $('#reported_by').text(reported_by);
                    $('#date_reported').text(date_reported);
                    $('#assigned_by').text(assigned_by);
                    $('#assigned_to').text(assigned_to);
                    $('#data_isAccepted').text(data_isAccepted);
                    $('#date_assigned').text(date_assigned);
                    $('#data_location').text(data_location);
                    $('#coordinate_lat_from_get').text(coordinate_lat);
                    $('#coordinate_lng_from_get').text(coordinate_lng);
                    $('#activity_date').text(activity_date);
                    $('#created_by').text(created_by);
                    $('#created_on').text(created_on);  
            }

            // Clear session data 
            function clearSessionData() {
                // sessionStorage.removeItem('reportedId');
                sessionStorage.removeItem('actionButton');
                sessionStorage.removeItem('reportedNumber');
                sessionStorage.removeItem('assignedTo');
                sessionStorage.removeItem('details');
                sessionStorage.removeItem('isAccepted');
                sessionStorage.removeItem('location');
                sessionStorage.removeItem('reportedBy');
                sessionStorage.removeItem('state');
                sessionStorage.removeItem('reportedNumber');
                sessionStorage.removeItem('coordinate_lat_from_put');
                sessionStorage.removeItem('coordinate_lng_from_put');
                // console.log("cleared session");
            }

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
