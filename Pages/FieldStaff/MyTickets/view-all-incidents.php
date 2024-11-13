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

    <script>
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
                            <div class="dropdown">
                                <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <button class="actionButton" id="acceptButton" onclick="acceptTicket(${row.id})">
                                            <i class="fas fa-edit" ></i> Accept
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
            window.location.href = "/Pages/FIeldStaff/MyTickets/view-incident-details.php";
            // console.log('clicked');
            
            var id = $(this).text();
            sessionStorage.setItem('id', id);
            
        });

        function acceptTicket(){
            alert('Accepted');
        }
            
       
    </script>
    <!-- ---------------------------------------------- -->
    
    <?php 
    include("../../../Pages/FieldStaff/nav-bar2.php");
    ?>
</body>
</html>
