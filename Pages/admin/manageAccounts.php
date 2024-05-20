<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");

// Assuming you have a database connection established, replace connection with your actual database connection
require_once "../../includes/db_connection.php";
require_once("../../templates/alert-message.php");

// Check if the user is logged in
if (!isset($_SESSION['session_id'])) {
    // Redirect the user to login page or handle accordingly
    header("Location: login.php");
    exit(); // Stop execution to prevent further code execution
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Accounts</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <?php include("../../templates/nav-bar.php"); ?>

    <!-- Alert message -->
    <?php 
    require_once("../../templates/alert-message.php");
    ?>

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
            background-color: rgba(255, 255, 255, 0.7); /* Adjust opacity here */
            z-index: -1; /* Ensure the pseudo-element is behind other content */
        }
        

       
        @media screen and (min-width: 320px) and (max-width: 425px) {
            #container{
                background-color: rgba(255, 255, 255, 0.8);
            }
                
            } 
    </style>
    <div class="container mt-4"  style="padding:3%">
        <h2>Users</h2>
        <input type="text" id="searchInput" class="form-control mb-2" style="width:20%" 
            <?php 
            $notification_user_name = isset($_GET['user_name']) ? $_GET['user_name'] : null;
            if ($notification_user_name == null) {
                echo 'placeholder="Search..."';
            }
            else{
                echo "value=\"$notification_user_name\"";
            }
            ?>
        >

        <div id="refreshDiv">
            <div class="table-responsive" style="padding:20px">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Created On</th>
                    <th>Status</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <!-- Table rows will be dynamically added here -->
                </tbody>
                </table>
            </div>
        </div>
        <ul class="pagination"></ul>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function(){
        var originalData; // Store the original data
            // Function to handle approve button click
            function handleApprove(id,buttonValue) {
                $.ajax({
                    url: 'approve_account.php',
                    type: 'GET',
                    data: { id: id, buttonValue:buttonValue }, // Pass the ID as data in the AJAX request
                    success: function(response) {
                        // Display response from approve.php (alert)
                        $("body").append(response);

                         // Update the status in the table without hiding the row
                        var row = $('#myTable').find('tr').filter(function () {
                            return $(this).find('td:first').text() == id; // Find the row with the corresponding user id
                        });

                        // Find the status cell in the row and update its text
                        row.find('td:nth-child(4)').text(buttonValue == 'Approve' ? 'active' : 'inactive');
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to approve:", error);
                    }
                });
            }
        
            // Fetch accounts data from PHP script
            $.ajax({
                url: 'fetch_accounts.php',
                type: 'GET',
                dataType: 'json',
                success: function(accountsData) {
                    originalData = accountsData; // Store the original data
                    paginate(originalData); // Pagination
                },
                error: function(xhr, status, error) {
                    console.error("Failed to fetch accounts data:", error);
                }
            });

            // Search functionality
            $('#searchInput').keyup(function(){
                var searchText = $(this).val().toLowerCase().trim();
                if (searchText === "") { // If search input is empty, reset the table
                    paginate(originalData);
                } else {
                    var filteredUsers = originalData.filter(function(user) {
                        return user.username.toLowerCase().indexOf(searchText) > -1 || user.id.toString().indexOf(searchText) > -1;;
                    });
                    paginate(filteredUsers); // Paginate filtered data
                }
            });

            // Pagination
            var itemsPerPage = 5;
            var currentPage = 1;

            function paginate(data) {
                $('#myTable').empty();
                var startIndex = (currentPage - 1) * itemsPerPage;
                var endIndex = startIndex + itemsPerPage;
                var paginatedData = data.slice(startIndex, endIndex);
                populateTable(paginatedData);
                renderPagination(Math.ceil(data.length / itemsPerPage));
            }

            // Populate table with data
            function populateTable(data) {
                $('#myTable').empty();
                $.each(data, function(i, user){
                    var row = $('<tr>');
                    row.append($('<td>').text(user.id));
                    row.append($('<td>').text(user.username));
                    row.append($('<td>').text(user.created_on));
                    row.append($('<td>').text(user.status));
                    var actions = $('<td>');
                    var approveBtn = $('<button class="btn btn-warning btn-sm mr-2">Approve</button>');
                    approveBtn.click(function() {
                        handleApprove(user.id,'Approve'); // Call handleApprove function with user id
                        
                    });
                    actions.append(approveBtn);

                    var deactivateBtn= $('<button class="btn btn-danger btn-sm">Deactivate</button>');
                    deactivateBtn.click(function() {
                        handleApprove(user.id,'Deactivate'); // Call handleApprove function with user id
                        
                    });
                    actions.append(deactivateBtn);

                    row.append(actions);
                    $('#myTable').append(row);
                });
            }

            function renderPagination(totalPages) {
                $('.pagination').empty();
                for (var i = 1; i <= totalPages; i++) {
                    var li = $('<li class="page-item"><a class="page-link">' + i + '</a></li>');
                    li.click(function(){
                        currentPage = parseInt($(this).text());
                        paginate(originalData);
                    });
                    $('.pagination').append(li);
                }
            }
        });

    </script>  
    
    <!-- Navbar 2 -->
    <?php include("../../templates/nav-bar2.php"); ?>
</body>

