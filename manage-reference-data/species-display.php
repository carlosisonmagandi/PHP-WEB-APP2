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
<input type="button" id="addSpeciesBtn" value="Add new record" class="btn btn-primary" style="background-color:#002f6c;color:#f8f9fa;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
<table id="speciesTable" class="table table-striped table-bordered" style="width:100%; font-size:11px;">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name of Species</th>
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
            <th>Name of Species</th>
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
    // Initialize DataTable
    $('#speciesTable').DataTable({
        "order": [[ 3, "desc" ]],
        "responsive": true
    });

    function fetchDataFromDB() {
        $.ajax({
            url: '/manage-reference-data/species-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var table = $('#speciesTable').DataTable();
                table.clear();
                
                var rows = [];
                $.each(response, function(index, row) {
                    var editButton = '<button class="btn btn-sm edit-btn" data-id="' + row.id + '"><i class="fas fa-edit"></i></button>';
                    var deleteButton = '<button class="btn btn-sm delete-btn" data-id="' + row.id + '"><i class="fas fa-trash-alt"></i></button>';
                    
                    rows.push([
                        row.id,
                        row.species_name,
                        row.species_description,
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

    $('#speciesTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        deleteRecord(id);
        //console.log("delete was clicked");
    });

    $('#speciesTable').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var speciesName = $(this).closest('tr').find('td:eq(1)').text(); 
        var speciesDescription = $(this).closest('tr').find('td:eq(2)').text();
        
        updateSpeciesRecord(id,speciesName,speciesDescription);
        //console.log("edit was clicked");
    });

    $('#addSpeciesBtn').on('click', function() {
        addNewRecord();
    });

    function addNewRecord() {
        Swal.fire({
            html:
                '<input id="speciesName" class="swal2-input" placeholder="Species Name">' +
                '<textarea id="speciesDescription" class="swal2-textarea" placeholder="Species Description"></textarea>',
            showDenyButton: true,
            showCancelButton: false,
            showCloseButton: true,  
            confirmButtonText: "Save",
            denyButtonText: `Don't save`,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const speciesName = document.getElementById('speciesName').value;
                const speciesDescription = document.getElementById('speciesDescription').value;

                if (speciesName === '' || speciesDescription === '') {// Validate if inputs are empty
                    Swal.fire("Error", "Species Name and Species Description are required", "error");
                    return;
                }
                checkSpeciesNameExists(speciesName).then(exists => {// Check if speciesName already exists
                    if (exists) {
                        Swal.fire("Error", "Species Name already exists", "error");
                    } else {
                        const data = {
                            speciesName: speciesName,
                            speciesDescription: speciesDescription
                        };
                        $.ajax({//Insert record
                            url: '/manage-reference-data/species-insert.php',
                            type: 'POST',
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify(data),
                            success: function(data) {
                                Swal.fire("Saved!", `Species Name: ${speciesName}, Species Description: ${speciesDescription}`, "success");
                                
                                fetchDataFromDB(); // Refresh the table
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status === 409) {
                                    Swal.fire("Error", "Species Name already exists", "error");
                                } else {
                                    console.error('Error:', error);
                                    // Handle other errors as needed
                                }
                            }
                        });
                    }
                }).catch(error => {
                    console.error('Error checking species name:', error);
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    };
    function checkSpeciesNameExists(speciesName) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/manage-reference-data/species-check-record.php',
                type: 'GET',
                data: {
                    speciesName: speciesName
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
                    url: '/manage-reference-data/species-delete.php',
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
    function updateSpeciesRecord(id, speciesName, speciesDescription) {
        Swal.fire({
            title: "Are you sure you want to update this record?",
            html:
            '<input id="inputSpeciesName" class="swal2-input" placeholder="Condition Type" value="' + (speciesName ? speciesName : '') + '">' +
            '<textarea id="inputSpeciesDescription" class="swal2-textarea" placeholder="Condition Description">' + (speciesDescription ? speciesDescription : '') + '</textarea>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            denyButtonText: `No, keep it`
        }).then((result) => {
            if (result.isConfirmed) {
                const updatedSpeciesName= $('#inputSpeciesName').val(); 
                const updatedSpeciesDescription = $('#inputSpeciesDescription').val();

                const updateSpeciesData = {
                    id: id,
                    speciesName: updatedSpeciesName,
                    speciesDescription: updatedSpeciesDescription
                };

                $.ajax({
                    url: '/manage-reference-data/species-update.php',
                    type: 'PUT',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(updateSpeciesData), // Corrected to updateData
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
