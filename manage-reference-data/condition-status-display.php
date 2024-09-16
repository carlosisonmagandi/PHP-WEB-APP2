<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condition Status Table</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<input type="button" id="addConditionButton" value="Add new record" class="btn btn-primary" style="background-color:#002f6c;color:#f8f9fa;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
<table id="conditionStatusTable" class="table table-striped table-bordered" style="width:100%; font-size:11px;">
    <thead>
        <tr>
            <th>Id</th>
            <th>Condition Type</th>
            <th>Description</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Condition Type</th>
            <th>Description</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js" ></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#conditionStatusTable').DataTable({
        "order": [[ 3, "desc" ]],
        "responsive": true
    });

    function fetchDataFromDB() {
        $.ajax({
            url: 'condition-status-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var dataTable = $('#conditionStatusTable').DataTable();
                dataTable.clear(); 
                var rows = [];

                $.each(response, function(index, row) {
                    var editButton = '<button class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '"><i class="fas fa-edit"></i></button>';
                    var deleteButton = '<button class="btn btn-sm btn-danger delete-btn" data-id="' + row.id + '"><i class="fas fa-trash-alt"></i></button>';

                    rows.push([
                        row.id,
                        row.condition_type,
                        row.condition_description,
                        row.created_on,
                        editButton + ' ' + deleteButton
                    ]);
                });

                dataTable.rows.add(rows).draw();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert("Error fetching data. See console for details.");
            }
        });
    }
    fetchDataFromDB();

    $('#conditionStatusTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        // alert('Delete button clicked for id: ' + id);
        deleteRecord(id);
    });

    $('#conditionStatusTable').on('click', '.edit-btn', function() {
    var id = $(this).data('id');
    var conditionType = $(this).closest('tr').find('td:eq(1)').text(); // Get condition_type from table row
    var conditionDescription = $(this).closest('tr').find('td:eq(2)').text(); // Get condition_description from table row
    updateRecord(id, conditionType, conditionDescription);
    });


    $('#addConditionButton').on('click', function() {
        addNewRecord();
    });

    function addNewRecord() {
        Swal.fire({
            html:
                '<input id="conditionType" class="swal2-input" placeholder="Condition Type">' +
                '<textarea id="conditionDescription" class="swal2-textarea" placeholder="Condition Description"></textarea>',
            showDenyButton: true,
            showCancelButton: false,
            showCloseButton: true,  
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        }).then((result) => {
            if (result.isConfirmed) {
                const conditionType = document.getElementById('conditionType').value;
                const conditionDescription = document.getElementById('conditionDescription').value;

                if (conditionType === '' || conditionDescription === '') {
                    Swal.fire("Error", "Condition Type and Condition Description are required", "error");
                    return;
                }

                checkConditionTypeExists(conditionType).then(exists => {
                    if (exists) {
                        Swal.fire("Error", "Condition Type already exists", "error");
                    } else {
                        const data = {
                            conditionType: conditionType,
                            conditionDescription: conditionDescription
                        };

                        $.ajax({
                            url: '/manage-reference-data/condition-status-insert.php',
                            type: 'POST',
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify(data),
                            success: function(data) {
                                console.log('Success:', data);
                                Swal.fire("Saved!", `Condition Type: ${conditionType}, Condition Description: ${conditionDescription}`, "success");
                                
                                fetchDataFromDB(); // Refresh the table
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                Swal.fire("Error", "Failed to save record", "error");
                            }
                        });
                    }
                }).catch(error => {
                    console.error('Error checking condition type:', error);
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    }

    function checkConditionTypeExists(conditionType) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/manage-reference-data/condition-status-check-record.php',
                type: 'GET',
                data: {
                    conditionType: conditionType
                },
                dataType: 'json',
                success: function(response) {
                    resolve(response.exists);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }


    //Delete button
    function deleteRecord(id) {
        Swal.fire({
            title: "Are you sure you want to delete this record?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            denyButtonText: `No, keep it`
        }).then((result) => {
            if (result.isConfirmed) {
                const data = {
                    id: id
                };

                $.ajax({
                    url: '/manage-reference-data/condition-status-delete.php',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    success: function(data) {
                        console.log('Success:', data);
                        Swal.fire("Deleted!", "was successfully deletd", "success");
                        fetchDataFromDB(); // Call this function to refresh the table
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire("Error", "Failed to delete record", "error");
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    }

    //Update button
    function updateRecord(id, conditionType, conditionDescription) {
        Swal.fire({
            title: "Are you sure you want to update this record?",
            html:
            '<input id="conditionType" class="swal2-input" placeholder="Condition Type" value="' + (conditionType ? conditionType : '') + '">' +
            '<textarea id="conditionDescription" class="swal2-textarea" placeholder="Condition Description">' + (conditionDescription ? conditionDescription : '') + '</textarea>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            denyButtonText: `No, keep it`
        }).then((result) => {
            if (result.isConfirmed) {
                const updatedConditionType = $('#conditionType').val(); 
                const updatedConditionDescription = $('#conditionDescription').val();

                const updateData = {
                    id: id,
                    conditionType: updatedConditionType,
                    conditionDescription: updatedConditionDescription
                };

                $.ajax({
                    url: '/manage-reference-data/condition-status-update.php',
                    type: 'PUT',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(updateData), // Corrected to updateData
                    success: function(response) {
                        console.log('Success:', response);
                        Swal.fire("Updated!", response.message, "success");
                        fetchDataFromDB(); // Call this function to refresh the table
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
    }
});


</script>

</body>
</html>
