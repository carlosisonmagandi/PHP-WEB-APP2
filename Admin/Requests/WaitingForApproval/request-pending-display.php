
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending List</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <!-- loader -->
    <link rel="stylesheet" href="/Styles/loader.css">
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .approve-btn,.reject-btn{
            background-color:#f8f9fa;
            color:#002f6c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size:11px;
        }
        .approve-btn:hover,.reject-btn:hover{
            background-color:#002f6c;
            color:#f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #checkIcon,#rejectIcon{
            margin-left:4px;
        }
    </style>
</head>
<body>

<table id="waitingForApprovalTable" class="table table-striped table-bordered" style="width:100%; font-size:11px;">
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
            <th>Actions &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
            
        </tr>
    </thead>
    <tbody>
        
    </tbody>
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
    $('#waitingForApprovalTable').DataTable({
        "order": [[ 3, "desc" ]],//order based on the latest created record
        "responsive": true
    });

    function fetchDataFromDB() {
        $.ajax({
            url: '/Admin/Requests/WaitingForApproval/request-pending-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var table = $('#waitingForApprovalTable').DataTable();
                table.clear();
                
                var rows = [];
                $.each(response, function(index, row) {
                    var actionButtons = '<button class="btn btn-sm approve-btn" data-id="' + row.id + '">Approve<i class="fas fa-check-circle" id="checkIcon"></i></button>' +
                        ' ' + 
                        '<button class="btn btn-sm reject-btn" data-id="' + row.id + '">Reject<i class="fas fa-times-circle" id="rejectIcon"></i></button>';
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
    fetchDataFromDB();

    $('#equipmentConditionTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        deleteRecord(id);
        //console.log("delete was clicked");
    });
    // -----------------------------------------------------------------
    
    const pusher = new Pusher('6bde96fb5927bfee7cdc', {
        cluster: 'ap1'
    });

    const channel = pusher.subscribe('display-channel');
    channel.bind('display-event', function(data) {
        fetchDataFromDB(); // Reload data
    });

    $('#waitingForApprovalTable').on('click', '.approve-btn', function() {
        var id = $(this).data('id');
        var requestNumber = $(this).closest('tr').find('td:eq(1)').text(); 
        var requestee = $(this).closest('tr').find('td:eq(2)').text(); 
        var office = $(this).closest('tr').find('td:eq(3)').text(); 
        var forestProductType = $(this).closest('tr').find('td:eq(4)').text(); 
        var species = $(this).closest('tr').find('td:eq(5)').text(); 
        var ownerOfRequest = $(this).closest('tr').find('td:eq(7)').text(); 
        var dateCreated = $(this).closest('tr').find('td:eq(8)').text(); 
       
        
        Swal.fire({
            title: "Are you sure you want to approve this record?",
            html:
            'Request #: <input disabled id="inputRequestNumber" class="swal2-input" placeholder="Request Number" value="'+ (requestNumber ? requestNumber : '') + '">' +
            'Requestee: <input disabled id="inputRequestee" class="swal2-input" placeholder="Requestee" value="' + (requestee ? requestee : '') + '">',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Approve it!",
            denyButtonText: `Cancel`
        }).then((result) => {
            if (result.isConfirmed) {
                const updatedRequestNumber= $('#inputRequestNumber').val(); 
                const updatedRequestee = $('#inputRequestee').val();

                const updateRequestData = {
                    id: id,
                    requestNumber: updatedRequestNumber,
                    requestee: updatedRequestee,
                    office:office,
                    forestProductType:forestProductType,
                    species,
                    ownerOfRequest,
                    dateCreated
                    
                };
                Swal.fire({
                    title: "Loading please wait",
                    html: '<br><center><div class="spinner"></div></center>',
                    icon: "info",
                    timer: 20000,  
                    showConfirmButton: false 
                });

                $.ajax({
                    url: '/Admin/Requests/WaitingForApproval/request-approve.php',
                    type: 'PUT',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(updateRequestData), // Corrected to updateData
                    success: function(response) {
                       
                        Swal.fire("Request has been approved!", response.message, "success");
                        
                        // fetchDataFromDB(); 
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

});


</script>

</body>
</html>
