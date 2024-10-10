<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved List</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
  
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .details-btn,.reject-btn{
            background-color:#f8f9fa;
            color:#002f6c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size:11px;
        }
        .details-btn:hover,.reject-btn:hover{
            background-color:#002f6c;
            color:#f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #checkIcon,#rejectIcon{
            margin-left:4px;
        }
        .details-btn:focus,.reject-btn:focus{
            background-color:#f8f9fa;
            color:#002f6c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size:11px;
        }
    </style>
    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body>

<table id="rejectedTable" class="table table-striped table-bordered" style="width:100%; font-size:11px;">
    <thead>
        <tr>
            <th>Id</th>
            <th>Request Number</th>
            <th>Requestee</th>
            <th>Office</th>
            <th>Forest product's type</th>
            <th>Species</th>
            <th>Status</th>
            <th>Owner of request (Staff)</th>
            <th>Date created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Request Number</th>
            <th>Requestee</th>
            <th>Office</th>
            <th>Forest product's type</th>
            <th>Species</th>
            <th>Status</th>
            <th>Owner of request (Staff)</th>
            <th>Date created</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>

<script>

$(document).ready(function() {
    // Initialize DataTable
    $('#rejectedTable').DataTable({
        "order": [[ 8, "desc" ]],//order based on the latest created record
        "responsive": true,
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50]
    });

    // Fetch approved data from the DB and populate the table
    function fetchRejectedDataFromDB() {
        $.ajax({
            url: '/Admin/Requests/Rejected/request-rejected-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var table = $('#rejectedTable').DataTable();
                table.clear();
                
                var rows = [];
                $.each(response, function(index, row) {
                    var actionButtons = '<button class="btn btn-sm details-btn" data-id="' + row.id + '">Details</button>';
                    var clickableId = '<a href="/Admin/Requests/RequestDetails/request.php?id=' + row.id + '" class="clickable-id" data-id="' + row.id + '">' + row.id + '</a>';
                    rows.push([
                        clickableId,
                        row.request_number,
                        row.requestor_name,
                        row.organization_name,
                        row.type_of_requested_item,
                        row.name_of_requested_item,
                        row.approval_status,
                        row.created_by,
                        row.created_on,
                        actionButtons
                    ]);
                });

                table.rows.add(rows).draw();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert("Error fetching data. See console for details.");
            }
        });
    }
    fetchRejectedDataFromDB(); // Call the function to populate the table
    const pusher = new Pusher('6bde96fb5927bfee7cdc', {
        cluster: 'ap1'
    });

    const channel = pusher.subscribe('rejected-channel');
    channel.bind('rejected-event', function(data) {
        fetchRejectedDataFromDB(); 
    });
    


});
</script>

</body>
</html>
