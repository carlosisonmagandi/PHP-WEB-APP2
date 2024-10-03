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
        .complete-btn,.reject-btn{
            background-color:#f8f9fa;
            color:#002f6c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size:11px;
        }
        .complete-btn:hover,.reject-btn:hover{
            background-color:#002f6c;
            color:#f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #checkIcon,#rejectIcon{
            margin-left:4px;
        }
    </style>
    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body>

<table id="approvedTable" class="table table-striped table-bordered" style="width:100%; font-size:11px;">
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
    $('#approvedTable').DataTable({
        "order": [[ 8, "desc" ]], // order by latest created record
        "responsive": true
    });

    // Fetch approved data from the DB and populate the table
    function fetchApprovedDataFromDB() {
        $.ajax({
            url: '/Admin/Requests/Approved/request-approved-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var table = $('#approvedTable').DataTable();
                table.clear();
                
                var rows = [];
                $.each(response, function(index, row) {
                    var actionButtons = '<button class="btn btn-sm complete-btn" data-id="' + row.id + '">Complete</button>';
                        
                    rows.push([
                        row.id,
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
    fetchApprovedDataFromDB(); // Call the function to populate the table

    // Handle the complete button click
    $('#approvedTable').on('click', '.complete-btn', function() {
        var id = $(this).data('id');
        var requestNumber = $(this).closest('tr').find('td:eq(1)').text(); 
        var requestee = $(this).closest('tr').find('td:eq(2)').text(); 
        
        Swal.fire({
            title: "Are you sure you want to complete this request?",
            html:
            'Request #: <input disabled id="inputRequestNumber" class="swal2-input" placeholder="Request Number" value="'+ (requestNumber ? requestNumber : '') + '">' +
            'Requestee: <input disabled id="inputRequestee" class="swal2-input" placeholder="Requestee" value="' + (requestee ? requestee : '') + '">',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Set to complete!",
            denyButtonText: `Cancel`
        }).then((result) => {
            if (result.isConfirmed) {
                const updateRequestData = {
                    id: id,
                    requestNumber: $('#inputRequestNumber').val(),
                    requestee: $('#inputRequestee').val()
                };

                $.ajax({
                    url: '/Admin/Requests/Approved/request-approved.php',
                    type: 'PUT',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(updateRequestData),
                    success: function(response) {
                        Swal.fire("Request has been set to complete!", response.message, "success");
                        fetchApprovedDataFromDB(); // Refresh the table
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire("Error", "Failed to update record", "error");
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });

    // Initialize Pusher for real-time updates
    Pusher.logToConsole = false;

    var pusher = new Pusher('6bde96fb5927bfee7cdc', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');

    // Bind Pusher event and handle incoming data
    channel.bind('my-event', function(data) {
        // console.log("Pusher event received!");
        
        // console.log("Received data: ", data);
        

        var table = $('#approvedTable').DataTable();

        var newRow = [
            data.requestId,
            data.requestNumber,
            data.requestee,
            data.office, // Replace with the actual field from your event data
            data.forestProductType,
            data.species,
            data.requestStatus,
            data.ownerOfRequest,
            data.dateCreated,
            '<button class="btn btn-sm complete-btn" data-id="' + data.requestId + '">Complete</button>'
        ];

        // Add the new row to the DataTable and redraw
        table.row.add(newRow).draw();

        // Optionally, you can show a notification or log something
        // Swal.fire("New request added!", "Request Number: " + data.requestNumber, "success");
    });


});
</script>

</body>
</html>
