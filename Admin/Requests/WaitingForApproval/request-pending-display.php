
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending List</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <!-- loader -->
    <link rel="stylesheet" href="/Styles/loader.css">
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- bootstrap scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <style>
        .approve-btn,.reject-btn,.remarks-btn{
            background-color:#f8f9fa;
            color:#002f6c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size:11px;
        }
        .approve-btn:hover,.reject-btn:hover,.remarks-btn:hover{
            background-color:#002f6c;
            color:#f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #checkIcon,#rejectIcon{
            margin-left:4px;
        }
        .approve-btn:focus, .reject-btn:focus, .remarks-btn:focus {
            outline: none; 
            box-shadow:  0 4px 8px rgba(0, 0, 0, 0.1); 
            background-color:#f8f9fa;
            color:#002f6c;
            font-size:11px;
        }
        .approve-btn:focus:hover,.reject-btn:focus:hover,.remarks-btn:focus{
            background-color:#002f6c;
            color:#f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        "order": [[ 8, "desc" ]],//order based on the latest created record
        "responsive": true,
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50]
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
                    var actionButtons = `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item approve-btn" data-id="${row.id}">Approve <i class="fas fa-check-circle" style="float:right"></i></a></li>
                                <li><a class="dropdown-item reject-btn" data-id="${row.id}">Reject <i class="fas fa-times-circle" style="float:right"></i></a></li>
                                <li><a class="dropdown-item remarks-btn" data-id="${row.id}">Remarks <i class="fas fa-pen" style="float:right"></i></a></li>
                            </ul>
                        </div>
                    `;
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
    fetchDataFromDB();

    //Reject button actions
    $('#waitingForApprovalTable').on('click', '.reject-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: "Please enter the reason for rejection.",
            html: '<textarea id="rejectionReason" rows="4" style="width: 100%;"></textarea>',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                const rejectionReason = $('#rejectionReason').val();
                $.ajax({
                    url: '/Admin/Requests/WaitingForApproval/request-rejected.php',
                    type: 'POST',
                    data: {
                        reason: rejectionReason,
                        requestId:id
                    },
                    success: function(response) {
                        // console.log(response);
                        const data = JSON.parse(response);
                        Swal.fire({
                            title: "Record rejected successfuly.",
                            text: data.message, 
                            icon: "success"
                        });
                        // -------------------------------------------
                        //Call request-rejected-update.php to update the status value to "rejected"
                        $.ajax({
                            url: '/Admin/Requests/WaitingForApproval/request-rejected-update.php',
                            type: 'POST',
                            data: JSON.stringify({
                                requestId: id 
                            }),
                            success: function(response) {
                                // console.log(response);
                                console.log("updated successfully");
                                
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "Error",
                                    text: "An error occurred while processing your request.",
                                    icon: "error"
                                });
                            }
                        });

                        // Call insert query for donation_monitoring
                        var actionDescription = 'Rejected by ';
                        var donationMonitoringData = {
                            incident_reports_id: id,
                            action_description: actionDescription,
                        };

                        $.ajax({
                            url: '/Admin/Monitoring/Donation/POST/insert-record.php',
                            type: 'POST',
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify(donationMonitoringData),
                            success: function(response) {
                                // console.log("Record successfully inserted:", response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                Swal.fire("Error", "Failed to insert record", "error");
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        Swal.fire({
                            title: "Error",
                            text: "An error occurred while processing your request.",
                            icon: "error"
                        });
                    }
                });
            } else if (result.isDenied) {
                Swal.fire({
                    title: "Changes not saved.",
                    icon: "info"
                });
            }
        });
    });

    // -----------------------------------------------------------------
    
    const pusher = new Pusher('6bde96fb5927bfee7cdc', {
        cluster: 'ap1'
    });

    const channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        fetchDataFromDB(); 
    });
    // reload based on trigger event from request-rejected-update.php
    const channelRejectedUpdate = pusher.subscribe('rejected-channel');
    channelRejectedUpdate.bind('rejected-event', function(data) {
        fetchDataFromDB(); 
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

                // Call insert query for donation_monitoring
                var actionDescription = 'Approved by ';
                var donationMonitoringData = {
                    incident_reports_id: id,
                    action_description: actionDescription,
                };

                $.ajax({
                    url: '/Admin/Monitoring/Donation/POST/insert-record.php',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(donationMonitoringData),
                    success: function(response) {
                        // console.log("Record successfully inserted:", response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire("Error", "Failed to insert record", "error");
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
