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

   
        ul {
            text-align: left;
            padding-left: 20px;
            list-style-type: none; 
            
        }

        li {
            text-align: left;
            list-style-position: outside;
        }


    </style>
</head>
<body>
    
    <?php 
    isset($_SESSION['session_role']) 
    ? include($_SESSION['session_role'] == 'Field_Staff' ? "../../Pages/FieldStaff/nav-bar.php" : "../../templates/nav-bar.php")
    : print("No session role found.");
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
        <h3>Donation Request Tracking</h3>
        <table id="requestFormDataTable" class="display" style="width:100%; border:1px solid black; font-size=10px;">
            <thead style="text-align:center;">
                <tr>
                    <th>REQUEST NUMBER</th>
                    <th>REQUESTEE</th>
                    <th>OFFICE</th>
                    <th>REQUEST (FOREST PRODUCT)</th>
                    <th>ACTIVITIES</th>
                </tr>
            </thead>
            <tbody id="dataBody" style="text-align:center;">
            </tbody>
            <tfoot>
                <tr>
                    <th>REQUEST NUMBER</th>
                    <th>REQUESTEE</th>
                    <th>OFFICE</th>
                    <th>REQUEST (FOREST PRODUCT)</th>
                    <th>ACTIVITIES</th>
                </tr>
            </tfoot>
        </table>

    </div>

    <script>
        $('#requestFormDataTable').DataTable({
            // "order": [[ 6, "desc" ]],
            "responsive": true,
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50],
            "columnDefs": [
                { "width": "35%", "targets": 4 } 
            ]
        });
        function fetchDataFromDB() {
    $.ajax({
        url: '/Admin/Monitoring/Donation/GET/get-record.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);

            var table = $('#requestFormDataTable').DataTable();
            table.clear();

            var rows = [];
            $.each(response, function(index, row) {
                rows.push([ 
                    row.request_number, 
                    row.created_by,
                    row.organization_name,
                    row.type_of_requested_item,
                    row.ACTIONS
                ]);
            });

            table.rows.add(rows).draw();
            table.order([5, 'desc']).draw();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert("Error fetching data. See console for details.");
        }
    });
}

fetchDataFromDB();

            
        //Dynamic Clickable Id 
        $(document).on('click', '.clickable-id', function() {
            // console.log('id clicked');
        });

        
            
       
    </script>
    <!-- ---------------------------------------------- -->
    
    <?php 
    isset($_SESSION['session_role']) 
    ? include($_SESSION['session_role'] == 'Field_Staff' ? "../../Pages/FieldStaff/nav-bar2.php" : "../../templates/nav-bar2.php")
    : print("No session role found.");
    ?>
</body>
</html>
