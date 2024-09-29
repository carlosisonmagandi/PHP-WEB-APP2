<?php
// echo "<script>alert('" . $_SESSION['activeTabName'] . "');</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condition Status Table</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-btn,.delete-btn{
            background-color:#f8f9fa;
            color:#002f6c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .edit-btn:hover,.delete-btn:hover{
            background-color:#002f6c;
            color:#f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
<input type="button" id="addVehicleTypeBtn" value="Add new record" class="btn btn-primary" style="background-color:#002f6c;color:#f8f9fa;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
<table id="vehicleTypeTable" class="table table-striped table-bordered" style="width:100%; font-size:11px;">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name of Type</th>
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
            <th>Name of Type</th>
            <th>Description</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#vehicleTypeTable').DataTable({
        "order": [[ 3, "desc" ]],//order based on the latest created record
        "responsive": true
    });

    function fetchDataFromDB() {
        $.ajax({
            url: '/manage-vehicle-ref-data/VehicleType/vehicle-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var table = $('#vehicleTypeTable').DataTable();
                table.clear();
                
                var rows = [];
                $.each(response, function(index, row) {
                    var editButton = '<button class="btn btn-sm edit-btn" data-id="' + row.id + '"><i class="fas fa-edit"></i></button>';
                    var deleteButton = '<button class="btn btn-sm delete-btn" data-id="' + row.id + '"><i class="fas fa-trash-alt"></i></button>';
                    
                    rows.push([
                        row.id,
                        row.type_title,
                        row.type_description,
                        row.created_on,
                        editButton + ' ' + deleteButton
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

    $('#vehicleTypeTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        deleteRecord(id);
        //console.log("delete was clicked");
    });

    $('#vehicleTypeTable').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var vehicleTitle = $(this).closest('tr').find('td:eq(1)').text(); 
        var vehicleDescription = $(this).closest('tr').find('td:eq(2)').text();
        
        updateVehicleRecord(id,vehicleTitle,vehicleDescription);
        //console.log("edit was clicked");
    });

    $('#addVehicleTypeBtn').on('click', function() {
        addNewRecord();
    });

    function addNewRecord() {
        Swal.fire({
            html:
                '<input id="vehicleTitle" class="swal2-input" placeholder="Vehicle Type">' +
                '<textarea id="vehicleDescription" class="swal2-textarea" placeholder="Vehicle Description"></textarea>',
            showDenyButton: true,
            showCancelButton: false,
            showCloseButton: true,  
            confirmButtonText: "Save",
            denyButtonText: `Don't save`,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
               
                const vehicleTitle = document.getElementById('vehicleTitle').value;
                const vehicleDescription = document.getElementById('vehicleDescription').value;
                if (vehicleTitle === '' || vehicleDescription === '') {// Validate if inputs are empty
                    Swal.fire("Error", "Inputs required", "error");
                    return;
                }
                checkVehicleNameExists(vehicleTitle).then(exists => {
                    if (exists) {
                        Swal.fire("Error", "vehicle Type already exists", "error");
                    } else {

                        const data = {
                            vehicleTitle: vehicleTitle,
                            vehicleDescription: vehicleDescription
                        };
                        $.ajax({//Insert record
                            url: '/manage-vehicle-ref-data/VehicleType/vehicle-insert.php',
                            type: 'POST',
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify(data),
                            success: function(data) {
                                Swal.fire("Saved!", `Vehicle type: ${vehicleTitle}, Vehicle Description: ${vehicleDescription}`, "success");
                                
                                fetchDataFromDB(); // Refresh the table
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status === 409) {
                                    Swal.fire("Error", "vehicle Name already exists", "error");
                                } else {
                                    console.error('Error:', error);
                                    // Handle other errors as needed
                                }
                            }
                        });
                    }
                }).catch(error => {
                    console.error('Error checking vehicle type:', error);
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    };
    function checkVehicleNameExists(vehicleTitle) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/manage-vehicle-ref-data/VehicleType/vehicle-type-check-record.php',
                type: 'GET',
                data: {
                    vehicleTitle: vehicleTitle
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
    };

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
                    url: '/manage-vehicle-ref-data/VehicleType/vehicle-delete.php',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(data),
                    success: function(data) {
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
    };

    //Update button
    function updateVehicleRecord(id, vehicleTitle, vehicleDescription) {
        Swal.fire({
            title: "Are you sure you want to update this record?",
            html:
            '<input id="inputVehicleTitle" class="swal2-input" placeholder="Vehicle Type" value="' + (vehicleTitle ? vehicleTitle : '') + '">' +
            '<textarea id="inputVehicleDescription" class="swal2-textarea" placeholder="Vehicle Description">' + (vehicleDescription ? vehicleDescription : '') + '</textarea>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            denyButtonText: `No, keep it`
        }).then((result) => {
            if (result.isConfirmed) {
                const updatedVehicleTitle= $('#inputVehicleTitle').val(); 
                const updatedVehicleDescription = $('#inputVehicleDescription').val();

                const updateVehicleData = {
                    id: id,
                    vehicleTitle: updatedVehicleTitle,
                    vehicleDescription: updatedVehicleDescription
                };

                $.ajax({
                    url: '/manage-vehicle-ref-data/VehicleType/vehicle-update.php',
                    type: 'PUT',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(updateVehicleData), // Corrected to updateData
                    success: function(response) {
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
    };
});


</script>

</body>
</html>
