<?php
session_start();
require("../../../includes/session.php");
require("../../../includes/darkmode.php");
require("../../../includes/authentication.php");

if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All list</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="/Styles/sb-admin/sb-admin-styles.css" rel="stylesheet" />
        
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <link rel="stylesheet" type="text/css" href="../../../Styles/darkmode.css">
        <link rel="stylesheet" type="text/css" href="../../../Styles/nav-bar.css">
        <!--  To switch dark mode on or off for notification -->
        <?php 
            if(isset($_SESSION['mode'])){
                if ($_SESSION['mode'] == 'dark') {
                    echo '<link rel="stylesheet" type="text/css" href="../../../Styles/notification-dark.css">';
                } else {
                    echo '<link rel="stylesheet" type="text/css" href="../../../Styles/notification.css">';
                }
            }else{
                echo '<link rel="stylesheet" type="text/css" href="../../../Styles/notification.css">';
            }
        ?>  
    <style>
         .tableDiv{
            font-family: 'Poppins', sans-serif;        
            font-size:10px;
            padding:25px;
        }
        .actionButton{
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
        }
        /* modal */
        .swal2-popup {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
            max-height: 100% !important;
            padding: 0;
            margin: 0;
            border-radius: 0;
        }

        

        .swal2-content {
            width: 100%;
            height: calc(100% - 80px); /* Reserve space for title */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: hidden;
        }

        /* Responsive div inside modal */
        .responsive-div {
            width: 100%;
            height: 100%;
            background-color: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        /* Style for the content inside the div */
        .content {
            text-align: center;
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>
    
    <?php 
    include("../../../Pages/FieldStaff/nav-bar.php");
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

    <!-- Content ----------------------------------------->
    <div class="tableDiv">
        <table id="assignToMeTable" class="display" style="width:100%; border:1px solid black; font-size=10px;" >
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

    <script>
        $('#assignToMeTable').DataTable({
            "order": [[ 12, "desc" ]],//order based on the latest created record
            "responsive": true,
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50]
        });
        function fetchDataFromDB() {
            $.ajax({
                url: '/Pages/FieldStaff/MyTickets/assign-to-me.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var table = $('#assignToMeTable').DataTable();
                    table.clear();
                    
                    var rows = [];
                    $.each(response.data, function(index, row) {
                        var actionButtons = `
                            <div class="dropdown">
                                <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <button class="actionButton" id="acceptButton" onclick="acceptTicket(${row.id})">
                                            <i class="fas fa-edit"></i> Accept
                                        </button>
                                        <button class="actionButton" id="mapButton" onclick="mapNavigation(${row.id})">
                                            <i class="fas fa-map-marker-alt"></i> View Map
                                        </button>
                                    </li>
                                </ul>
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
            
        //Dynamic Clickable Id 
        $(document).on('click', '.clickable-id', function() {
            //set value for action button
            window.location.href = "/Pages/FieldStaff/MyTickets/view-incident-details.php";
            // console.log('clicked');
            
            var id = $(this).text();
            sessionStorage.setItem('id', id);
        });

        function acceptTicket(id) {
            var myTicketId = id;
           
            $.ajax({
                url: '/Pages/FieldStaff/MyTickets/accept-ticket.php',
                type: 'PUT',
                data: JSON.stringify({ id: myTicketId }),  
                contentType: 'application/json',           
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        Swal.fire('Success!', data.message || 'Ticket Accepted!', 'success');
                        fetchDataFromDB();
                    } else {
                        Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                }
            });
        }
        // Map Navigation
        function mapNavigation(id){
            $.ajax({
                url: '/Pages/FieldStaff/MyTickets/map.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    if (Array.isArray(response) && response.length > 0) {
                        const latitude = response[0].coordinate_lat;
                        const longitude = response[0].coordinate_lng;
                        
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                const userLatitude = position.coords.latitude;
                                const userLongitude = position.coords.longitude;
                                // Open Google Maps with user's current location
                                const url = `https://www.google.com/maps/dir/?api=1&origin=${userLatitude},${userLongitude}&destination=${latitude},${longitude}`;
                                window.open(url, "_blank");
                            }, function() {
                                console.log('Unable to retrieve your location');
                            });
                        } else {
                            console.log('Geolocation is not supported by this browser.');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        }

            
       
    </script>
    <!-- ---------------------------------------------- -->
    
    <?php 
    include("../../../Pages/FieldStaff/nav-bar2.php");
    ?>
</body>
</html>
