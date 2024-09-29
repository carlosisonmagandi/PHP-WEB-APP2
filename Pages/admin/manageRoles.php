<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");

require_once "../../includes/db_connection.php";

require("../../includes/authentication.php");

if ($_SESSION['session_role']!='Admin') {// Check if the user is logged in
    header("Location: ../../templates/page-restriction.php");
    exit();
}
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
<!-- CSS for role buttons -->
<style>
    body {
            background-image: url('/Images/manage-accounts.png');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: right bottom;
    }
    body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%; /* Cover the entire body */
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9); /* Adjust opacity here */
            z-index: -1; /* Ensure the pseudo-element is behind other content */
    }
    .admin-role-btn, .staff-role-btn {
        background-color: #f8f9fa;
        color: #002f6c;
        border: 1px solid #002f6c;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-size: 11px;
        border-radius: 1px;
    }

    .admin-role-btn:hover, .staff-role-btn:hover {
        background-color: #002f6c;
        color: #f8f9fa;
    }
</style>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#accountRole').DataTable({
            "responsive": true
        });

        // Handle role change button click
        $('#accountRole tbody').on('click', '.admin-role-btn, .staff-role-btn', function() {
            var data = table.row($(this).parents('tr')).data();
            var accountId = data[0];
            var newRole = $(this).hasClass('admin-role-btn') ? 'Admin' : 'Staff';

            
            $.ajax({//Update Role
                url: 'manageRoleUpdate.php',
                method: 'POST',
                data: {
                    accountId: accountId,
                    newRole: newRole
                },
                dataType: 'json',
                success: function(response) {
                    Swal.fire('Success', response.message, 'success');
                    fetchDataFromDB();// refresh the view
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to update role. See console for details.', 'error');
                }
            });
        });

        function fetchDataFromDB() {//Get data 
            $.ajax({
                url: 'manageRole-fetch-record.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    table.clear().draw();
                    $.each(response, function(index, row) {
                        var roleButton;
                        if (row.role === 'Staff') {
                            roleButton = '<button class="btn btn-sm admin-role-btn"><i class="fas fa-user-shield"></i> Admin</button>';
                        } else if (row.role === 'Admin') {
                            roleButton = '<button class="btn btn-sm staff-role-btn"><i class="fas fa-user-tie"></i> Staff</button>';
                        } else {
                            roleButton = ''; // Handle any other roles if necessary
                        }

                        table.row.add([
                            row.id,
                            row.username,
                            row.role,
                            roleButton
                        ]).draw();
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to fetch data. See console for details.', 'error');
                }
            });
        }
        fetchDataFromDB();// Initial fetch
    });
</script>

<?php include("../../templates/nav-bar2.php"); ?>
</body>
</html>
