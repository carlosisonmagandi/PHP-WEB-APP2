<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");

require_once "../../includes/db_connection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Roles</title>

    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Styles/breadCrumbs.css">

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include("../../templates/nav-bar.php"); ?>
        
<div class="container" style="padding:40px">

    <!-- breadcrumbs -->
    <?php if ($_SESSION['mode'] == 'light'): ?>
        <div class="breadcrumb flat">
                <a href="#">Account Management</a>
                <a href="#" class="active">Roles</a>
            </div>
        <?php else: ?>
            <div class="breadcrumb">
                <a href="#">Account Management</a>
                <a href="#" class="active">Roles</a>
            </div>
        <?php endif; ?>

    <table id="accountRole" class="table table-striped table-bordered" style="width:100%; font-size:11px;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- place the style here for button because of the php tags -->
<style>
        .admin-role-btn,.staff-role-btn{
            background-color:#f8f9fa;
            color:#002f6c;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        }
        .admin-role-btn:hover,.staff-role-btn:hover{
            background-color:#002f6c;
            color:#f8f9fa;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        }
        
    </style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>

<script>
    //Initialize DataTable
    $('#accountRole').DataTable({
            // "order": [[ 3, "desc" ]],
            "responsive": true
    });
    $(document).ready(function() {
        
        function fetchDataFromDB() {
            $.ajax({
                url: 'manageRole-fetch-record.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#accountRole').DataTable().clear().draw();
                    $.each(response, function(index, row) {
                        var roleAdminButton = 'Change to: <button class="btn btn-sm admin-role-btn" data-id="' + row.id + '"><i class="fas fa-user-shield"></i> Admin</button>';
                        var roleStaffButton = '<button class="btn btn-sm staff-role-btn" data-id="' + row.id + '"><i class="fas fa-user-tie"></i> Staff</button>';

                        $('#accountRole').DataTable().row.add([
                            row.id,
                            row.username,
                            row.role,
                            roleAdminButton + roleStaffButton 
                        ]).draw();
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert("Error fetching data. See console for details.");
                }
            });
        }
        fetchDataFromDB();
    });
</script>

<?php include("../../templates/nav-bar2.php"); ?>
</body>
</html>