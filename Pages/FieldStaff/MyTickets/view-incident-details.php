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
        .back-to-list{
            background-color: transparent; 
            color: #002f6c;
            border: none;
            padding: 6px;
            font-size: 18px;
            border-bottom: 2px solid #002f6c; 
            padding-bottom: 4px;
            float:right;
            margin-bottom:25px;
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
    <button class="back-to-list" id="backToList">Back to List</button>
    <br>
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

    <script>
        $(document).ready(function() {

            const savedId = sessionStorage.getItem('id');
            console.log(savedId);

            if (savedId) {
                $.ajax({
                    url: '/ReportedIncidents/Staff/GET/get-record-by-id.php',
                    type: 'GET',
                    data: { reported_id: savedId },
                    dataType: 'json',
                    success: function(data) {
                        // window.location.href = "/ReportedIncidents/Staff/display.php";
                        if (data.status === 'success') {
                            let record = data.data;
                            // Populate HTML with AJAX response data
                            
                            $('#id').text(record.id);
                            $('#report_number').text(record.report_number);
                            $('#illegal_activity_detail').text(record.illegal_activity_detail);
                            $('#data_state').text(record.state);
                            $('#reported_by').text(record.reported_by);
                            $('#date_reported').text(record.date_reported);
                            $('#assigned_by').text(record.assigned_by);
                            $('#assigned_to').text(record.assigned_to);
                            $('#data_isAccepted').text(record.isAccepted);
                            $('#date_assigned').text(record.date_assigned);
                            $('#data_location').text(record.location);
                            $('#coordinate_lat_from_get').text(record.coordinate_lat);
                            $('#coordinate_lng_from_get').text(record.coordinate_lng);
                            $('#activity_date').text(record.activity_date);
                            $('#created_by').text(record.created_by);
                            $('#created_on').text(record.created_on);

                            
                        } else {
                            Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                    }
                });
            }    
        });

        $('#backToList').on('click', function() {
            window.location.href = "/Pages/FieldStaff/MyTickets/view-all-incidents.php";
        });
    </script>
        
    <!-- ---------------------------------------------- -->
    
    <?php 
    include("../../../Pages/FieldStaff/nav-bar2.php");
    ?>
</body>
</html>
