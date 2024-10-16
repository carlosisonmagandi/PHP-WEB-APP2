<?php
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");


//action after logout button
if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: ../../index.php");
    exit;
};
// getting id from URL
$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$queryString = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

$id = $queryString;
$hasId = !empty($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory List</title>

<!-- nav-bar -->
<link rel="stylesheet" type="text/css" href="/Styles/styles.css">
<link rel="stylesheet" type="text/css" href="/Styles/darkmode.css">

<?php 
 if ($_SESSION['mode'] == 'light') {
        echo '<link rel="stylesheet" type="text/css" href="/Styles/manage-ref-data-home.css">';
    } else if ($_SESSION['mode'] == 'dark') {
        echo '<link rel="stylesheet" type="text/css" href="/Styles/inventory/inventoryMainViewDM.css">';
    }
?>

<style>
    body{
        font-family: 'Poppins', sans-serif;        
        font-size:10px;
    }
        
    .flex-container {
    display: flex;
    flex-direction: row;
    /* text-align: center; */
    }

    .flex-item-left {
    flex: 80%;
    }

    .flex-item-right {
    flex: 5%;
    }
    .flex-container .flex-item-right button:hover{
        background-color:#D3D3D3;
    } 

    /* custom style for map modal */
    .main-map-container {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container {
        width: 80%; 
        max-width: 600px; 
        border: 1px solid #ccc;
        padding: 20px;
    }
    .content {
        /* text-align: center; */
    }
    .coordinates{
        background-color:#000;
        color:#FFF;
        position:absolute;
        bottom:80px;
        left:40px;
        padding-top: 15px ;
        padding-left:15px;
        padding-right:15px;
        margin:0;
        font-size:12px;
        line-height:6px;  
    }
    /* Style for input elements in footers */
    tfoot input {
        width: 100%;
        box-sizing: border-box;
        padding: 4px;
    }

    tfoot th {
        text-align: center;
    }

    @media (max-width: 800px) {
    .flex-container {
        flex-direction: column;
    }
    .content{
        overflow-x:scroll; 
    }
    } 
</style>
</head>
<body>
<?php 
include ("../templates/nav-bar.php");
?>
<br>

<!-- Scripts -->
<!-- Note: It will not work inside header because of the php block for templates -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<!-- data table -->
<script src="/Styles/data-table/jquery-3.7.1.js"></script>
<script src="/Styles/data-table/dataTables.js"></script>
<link href="/Styles/data-table/dataTables.css" rel="stylesheet" />

<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
<div class="mainContaier" >
    <div class="flex-container">
        <div class="flex-item-left" id="titleContainer">
            <!-- title -->
            <h3 style="font-size:12px; font-weight:bold"><center>INVENTORY OF APPREHENDED/CONFISCATED DEPOSITED AT THE IMPOUNDING AREA OF PENRO LAGUNA </ceter></h3>
        </div>
        <div class="flex-item-right">
            <button onclick="redirectToUrl()" class='btn btn-default' id="addNewButton" style="border:1px solid #e0e0e0;box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); font-size:12px; padding:9px;  ">
                Add New
            </button>

            <!-- Print icon button -->
            <button onclick="printVehicleTable()" class='btn btn-default' id="printTableButton" style="border:1px solid #e0e0e0; margin-left: 5px;box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
                <i class="bi bi-printer"></i> 
            </button>
        </div>
    </div>

    <div class="container-div" style="display: flex;flex-direction: column; margin-top:12px; font-size:10px;padding:10px">
        <div class="content" style="flex-grow: 1; " ><!--Removed overflow-x:scroll; -->
            <!-- overflow-x:scroll; -->
            <table id="vehicleDataTable" class="display" style="width:100%; border:1px solid black; font-size=10px;" >
            <thead style="text-align:center; " >
            <tr>
                <th style="width:10%;">ID</th>
                <th>VEHICLE NAME</th>
                <th>VEHICLE TYPE</th>
                <th>PLATE NUMBER</th>
                <th>BRAND</th>
                <th>MODEL</th>
                <th>LOCATION</th>
                <th>DATE OF CONFISCATION</th>
                <th>VEHICLE OWNER</th>
                <th>CONDITION</th>
                <th>REMARKS</th>
                <th>ACTIVITY DATE</th>
                <th>DATE CREATED</th>
                <th>CREATED BY</th>
                <th>UPDATED BY</th>
                <th>STATUS</th>
                <th>APPREHENDING PERSON/OFFICER</th>
                <th>ACTIONS</th>
            </tr>
            </thead>
            <tbody id="dataBody" style="text-align:center;">
            </tbody>

            <tfoot>
                <tr>
                <th style="width:10%;">ID</th>
                <th>VEHICLE NAME</th>
                <th>VEHICLE TYPE</th>
                <th>PLATE NUMBER</th>
                <th>BRAND</th>
                <th>MODEL</th>
                <th>LOCATION</th>
                <th>DATE OF CONFISCATION</th>
                <th>VEHICLE OWNER</th>
                <th>CONDITION</th>
                <th>REMARKS</th>
                <th>ACTIVITY DATE</th>
                <th>DATE CREATED</th>
                <th>CREATED BY</th>
                <th>UPDATED BY</th>
                <th>STATUS</th>
                <th>APPREHENDING PERSON/OFFICER</th>
                <th>ACTIONS</th>
                </tr>
            </tfoot>
            </table>
        </div>
    </div>

</div>


<script>
    let tableData = [];
    let currentPage = 1;
    const pageSize = 5;

    new DataTable('#vehicleDataTable', {
        initComplete: function () {
            const api = this.api();
             // Hide columns in a single operation
            api.columns([
                8,//vehicle_owner
                9,//condition
                10,//Remarks
                11,//Activity date
                12,//Date creaed
                13,//Created by
                14,//Updated By
                15,//Status
                16// Apprehnding officer
            ]).visible(false);

            api.columns().every(function (index) { 
                const column = this;
                const footer = column.footer();

                if (index !== 13) { 
                    const input = document.createElement('input'); 
                    input.placeholder = column.footer().textContent;

                    if (footer) { // Clear the footer and append the input
                        footer.innerHTML = ''; 
                        footer.appendChild(input);

                        // Event listener for user input
                        input.addEventListener('keyup', debounce(() => {
                            if (column.search() !== input.value) {
                                column.search(input.value).draw();
                            }
                        }, 300));
                    }
                }
            });
        }
    });

    // Debounce function to limit the rate at which the search is performed
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function fetchDataFromDB() {
        $.ajax({
            url: '/vehicles/get-record.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // console.log('Success:', response);
                updateTable(response);//call updateTable
            },
            error: function(xhr, status, error) {
                // console.error('Error:', error);
                // console.log(xhr.messageText);
                // console.log(xhr);
            }
        });
    }

    function updateTable(data) {
        //  console.log("data:",data);
        const table = $('#vehicleDataTable').DataTable();
        table.clear();// Clear the existing data from the DataTable
        data.forEach(rowData => {// Add new data
        const rowDataArray = [];
            
            Object.values(rowData).forEach(value => {
                rowDataArray.push(value);
            });
            
            const id = rowData['id'];
            rowDataArray.push(`
            <div class="dropdown">
                <button type="button" class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item edit-action"> Edit <i class="bi bi-pencil-fill" style="float:right"></i></a></li>
                    <li><a class="dropdown-item delete-action"> Delete <i class="bi bi-trash-fill" style="float:right"></i></a></li>
                </ul>
            </div>
            `);
            table.row.add(rowDataArray);// Add the row to the DataTable
        });
        table.order([12, 'desc']).draw();// Redraw the DataTable
    }

    $(document).ready(function() {//call fetchDataFromDb on page load
        clickableVehicleId();
        
        var hasId = <?php echo json_encode($hasId); ?>;
        var id = <?php echo json_encode($id); ?>;

        if (hasId) {
            itemClickId(id);
        }else{
            fetchDataFromDB();
        };

        // Event listener for edit action
        $('#vehicleDataTable').on('click', '.edit-action', function() {
            const id = $(this).closest('tr').find('td:first').text();
            sessionStorage.setItem('viewType', 'table');
            let viewType = sessionStorage.getItem('viewType');
            // console.log(viewType);
            editAction(id);
        });

        // Event listener for delete action
        $('#vehicleDataTable').on('click', '.delete-action', function() {
            const id = $(this).closest('tr').find('td:first').text();
            deleteAction(id);
        });
    });

    function clickableVehicleId(){
        //clickable id
        $('#vehicleDataTable').on('click', '.clickable-vehicle-id', function() {
            // console.log('You clicked on id: ' + $(this).text());
            var id = $(this).text();
            itemClickId(id);
        });
    }

    //Edit function
    function editAction(id) {
        //console.log(id);
        $.ajax({
            url: '/vehicles/get-record-by-id.php',
            type: 'GET',
            data: { vehicle_id: id },
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    // Construct query string with data
                    let queryString = id;
                    // console.log(data.data.equipment_condition);
                     sessionStorage.setItem('vehicle_type', data.data.vehicle_type );
                     sessionStorage.setItem('vehicle_condition', data.data.vehicle_condition );
                     sessionStorage.setItem('vehicle_status', data.data.vehicle_status );
                    // console.log(data);
                    // console.log(queryString);

                    // Redirect with query parameters
                    window.location.href = '/vehicles/add-record-view.php?' + queryString;
                } else {
                    Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
            }
        });
    }

    //Delete function
    function deleteAction(id) {
        // alert('Delete successful for ID: ' + id);

        $.ajax({
            url: '/equipments/delete-record.php',
            type: 'POST',
            data: { equipment_id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // console.log(response);
                    fetchDataFromDB();//reload the table
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while deleting the image.',
                    icon: 'error'
                });
            }
        });
    }
    function itemClickId(id) {
        //Image pane funtions
        $.ajax({
            url: '/vehicles/vehicle-get-images.php',
            type: 'GET',
            data: { vehicle_id: id },
            dataType: 'json',
            success: function(response) { 
                  //console.log(response); 
                // Expected data
                if (response) {
                    let htmlContent = ``;


                    if (response.images.length > 0) {
                        response.images.forEach(function(image) {
                            htmlContent += `
                            <style>
                            .flex-container {
                                display: flex;
                                flex-direction: row; 
                            }

                            .flex-item-left-img {
                                background-color: #f1f1f1;
                                width:20% !important; 
                                margin: 5px; 
                            }
                            .button-trash {
                                background-color: rgba(0, 0, 0, 0.5);
                                border: none; 
                                color: white; 
                                height:100%;
                                padding:6px;
                                border-radius:3px;
                                font-size: 15px;
                                float: right;
                                margin-top:10px;
                                margin-left: 55%;
                                display: flex;
                                align-items: center; 
                                justify-content: center; 
                                transition: background-color 0.3s; 
                            }

                            .button-trash:hover {
                                background-color: rgba(0, 0, 0, 0.7);
                            }

                            .button-trash i {
                                margin-bottom: 10px; 
                            }
                        
                            </style>
                            <div>    
                                <div class="flex-container">
                                    <div class="flex-item-left-img">
                                        <p style="display:none">${image.id}</p>
                                        <img src="${image.file_path}" alt="${image.file_name}" style="max-height: 180px;max-width:180px;box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);">
                                    </div> 
                                    <button data-id="${image.id}" class="button-trash delete-button" id="buttonId">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div> 
                            </div>`;
                        });
                    } else {
                        htmlContent +=`
                        <style>
                            .flex-container {
                                display: flex;
                                flex-direction: row; 
                            }
                            .flex-item-left-img {
                                flex: 1; 
                                margin: 5px; 
                                position: relative; 
                                background: rgba(0, 0, 0, 0.6); 
                                color: white;
                                align-items: center;
                                justify-content: center;
                                text-align: center;
                                font-size: 16px;
                                height: 100px; 
                            }

                            .flex-item-left-img .hover-text {
                                display: flex; 
                                height: 100%;
                                width: 100%;
                                align-items: center;
                                justify-content: center;
                                cursor: pointer;
                            }
                        </style>

                        <div>    
                            <div class="flex-container">
                                <div class="flex-item-left-img">
                                    <div class="hover-text"><i class="fas fa-image"></i><span>&nbsp&nbsp</span>No image found.</div>
                                </div> 
                            </div>
                        </div>
                        `;
                    }

                    function getHtmlContent() {
                        return `
                        <style>
                            .flex-container {
                                display: flex;
                                background-color: #f1f1f1;
                                overflow-x: auto;
                                -webkit-overflow-scrolling: touch;
                                width: 100%;  
                            }
                            .flex-container-left {
                                color: black;
                                width: 20%;
                                margin: 10px;
                                text-align: center;
                                border-right:1px solid gray;
                                height:600px;
                            }
                            .flex-container-right {
                                color: black;
                                width: 100%;
                            }
                            .addImageButton {
                                display: inline-block;
                                padding: 10px 20px; 
                                font-size: 12px; 
                                font-family: Arial, sans-serif; 
                                color: #fff;
                                background-color: #002f6c; 
                                border: none;
                                border-radius: 5px; 
                                cursor: pointer; 
                                text-align: center; 
                                text-decoration: none; 
                                transition: background-color 0.3s, box-shadow 0.3s; 
                                margin-top:10px;
                            }
                            .addImageButton:hover {
                                background-color: #0056b3;
                            }
                            .addImageButton:active {
                                background-color: #004494; 
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                            }
                            .grid-container {
                                display: grid;
                                grid-template-columns: repeat(2, 1fr); 
                                grid-template-rows: auto auto;
                                gap: 10px;
                                background-color:#e0e0e0;
                                padding: 10px;
                                font-family: Arial, sans-serif;
                                font-size:12px;
                                overflow-x: auto;
                                -webkit-overflow-scrolling: touch;  
                            }
                            .grid-item {
                                background-color: rgba(255, 255, 255, 0.8);
                                text-align: center;
                                padding: 20px;
                            }
                            .item3 {
                                grid-column: 1 / span 2; 
                                grid-row: 2; 
                            }
                            .item4 {
                                grid-column: 1 / span 2; 
                                grid-row: 3; /* Change this to place item4 below item3 */
                            }
                            .item1 {
                                grid-column: 1;
                                grid-row: 1; 
                            }
                            .item2 {
                                grid-column: 2;
                                grid-row: 1; 
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 20px;
                            }
                            th, td {
                                border: 1px solid #ccc;
                                padding: 8px;
                                text-align: center;
                                overflow-x: auto;
                                -webkit-overflow-scrolling: touch;
                                
            
                            }
                            .category-header {
                                background: linear-gradient(90deg, #002f6c, #0073e6 50%, #002f6c);
                                color: white;
                                font-size: 18px;
                                font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                            }
                            .sub-category-header {
                                 background: linear-gradient(90deg, #002f6c, #0073e6 50%, #002f6c);
                                color: white;
                                font-size: 18px;
                                font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                            }
                            .table-container {
                                margin-bottom: 20px;
                            }

                            /*Mobile responsive style*/
                            @media (max-width: 600px) {
                                    th, td {
                                    white-space: nowrap; /* Prevent text from wrapping */
                                }
                            }
                        </style>
                        <div class="flex-container">
                            <div class="flex-container-left" style="overflow-y:scroll">
                                <input type="button" value="Add Image" class="addImageButton" id="vehicleAddImage" />
                                ${htmlContent}
                            </div>
                            <div class="flex-container-right">
                                <br>
                                <div class="grid-container">
                                    <div class="grid-item item1">
                                        <table>
                                            <tr>
                                                <th colspan="5" class="sub-category-header">Ownership</th>
                                            </tr>
                                            <tr>
                                                <td><b>ID &nbsp&nbsp&nbsp</b></td>
                                                <td><b>Name of Respondent/Claimant/Owner</b></td>
                                                <td><b>Apprehension Date</b></td>
                                                <td><b>Apprehending Officer</b></td>
                                                
                                            </tr>
                                            <tr>
                                                <td>${response.id}</td>
                                                <td>${response.vehicle_owner}</td>
                                                <td>${response.date_of_compiscation}</td>
                                                <td>${response.confiscated_by}</td>
                                            </tr>
                                        </table>
                                    </div>  
                                    <div class="grid-item item2">
                                        <table>
                                            <tr>
                                                <th colspan="4" class="sub-category-header">Activities</th>
                                            </tr>
                                            <tr>
                                                <td><b>Created By</b></td>
                                                <td><b>Last Updated</b></td>
                                                <td><b>Remarks</b></td>
                                            </tr>
                                            <tr>
                                                <td>${response.created_by}</td>
                                                <td>${response.date_of_compiscation}</td>
                                                <td>${response.remarks}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="grid-item item3">
                                        <table>
                                            <tr>
                                                <th colspan="8" class="category-header">Conveyance Description</th>
                                            </tr>
                                            <tr>
                                                <td><b>Plate #</b></td>
                                                <td><b>Brand</b></td>
                                                <td><b>Type</b></td>
                                                <td><b>Model Name</b></td>
                                                <td><b>Year Model</b></td>
                                                <td><b>Condition</b></td>
                                                <td><b>Status</b></td>
                                                <td><b>Location</b></td>
                                                
                                                
                                            </tr>
                                            <tr>
                                                <td>${response.plate_no}</td>
                                                <td>${response.brand}</td>
                                                <td>${response.vehicle_type}</td>
                                                <td>${response.vehicle_name}</td>
                                                <td>${response.model}</td>
                                                <td>${response.vehicle_condition}</td>
                                                <td>${response.vehicle_status}</td>
                                                <td>${response.location}</td>   
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                    }

                    Swal.fire({
                        text: `Inventory ID: ${id}`,
                        html: getHtmlContent(),
                        showConfirmButton: false,
                        didOpen: () => {
                            document.querySelector('.swal2-popup').style.width = '90%';

                            document.querySelectorAll('.delete-button').forEach(button => {//delete icon button
                                button.addEventListener('click', function() {
                                    let buttonId = this.getAttribute('data-id');
                                    $.ajax({
                                        url: '/vehicles/delete-image.php',
                                        type: 'POST',
                                        data: { image_id: buttonId },
                                        dataType: 'json',
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire({
                                                    title: 'Success',
                                                    text: response.message,
                                                    icon: 'success'
                                                }).then(() => {
                                                    // Call the function to update and reopen the modal
                                                    Swal.fire({
                                                        html: itemClickId(id)
                                                    })
                                                });
                                            } else {
                                                Swal.fire({
                                                    title: 'Error',
                                                    text: response.message,
                                                    icon: 'error'
                                                });
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'An error occurred while deleting the image.',
                                                icon: 'error'
                                            });
                                        }
                                    });
                                });
                            });

                            // add new image button
                            const buttonAddImage = document.getElementById('vehicleAddImage');
                            buttonAddImage.addEventListener('click', vehicleAddImageFunction);

                            function vehicleAddImageFunction() {
                                Swal.fire({
                                    html: `
                                        <div style="text-align: center;">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 60px; display: block; margin: 0 auto 15px;"></i>
                                            <input type="file" name="images[]" id="images" multiple>
                                            <br><br>
                                            <p style="color:gray;font-size:14px;font-style:italic">Allowed files: 'jpg', 'jpeg', 'png', 'gif'</p>
                                            <input type="hidden" name="action" value="upload_img">
                                            <input type="hidden" id="record_id" name="record_id" value="${id}">
                                            <input type="button" class="btn btn-success" value="Upload" id="uploadImage" / style="float:right">
                                        </div>
                                    `,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    allowOutsideClick: true
                                }).then(() => {
                                    // $('#dataTable').hide();
                                    Swal.fire({
                                        html: itemClickId(id)
                                    });
                                });

                                // Call AJAX for upload button
                                const buttonUploadImage = document.getElementById('uploadImage');
                                const fileInput = document.getElementById('images');

                                buttonUploadImage.addEventListener('click', () => {
                                    if (!fileInput) {
                                        console.error('File input element not found');
                                        return;
                                    }
                                    functionUploadImage(fileInput);
                                });

                                function functionUploadImage(fileInput) {
                                    const formData = new FormData();
                                    formData.append('action', 'upload_img'); 
                                    formData.append('record_id', document.getElementById('record_id').value);

                                    // Append files
                                    let images = fileInput.files;
                                    for (let i = 0; i < images.length; i++) {
                                        formData.append('images[]', images[i]);
                                    }

                                    $.ajax({
                                        url: '/vehicles/upload-image.php',
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success: function(response) {
                                            if (response.status === 'success') {
                                                Swal.fire({
                                                    title: 'Success',
                                                    text: 'Image uploaded successfully',
                                                    icon: 'success'
                                                }).then(() => {
                                                    // Call the function to update and reopen the modal
                                                    Swal.fire({
                                                        html: itemClickId(id)
                                                    })
                                                });
                                            } else {
                                                Swal.fire({
                                                    title: 'Error',
                                                    text: response.message,
                                                    icon: 'error'
                                                }).then(() => {
                                                    // Call the function to update and reopen the modal
                                                    Swal.fire({
                                                        html: itemClickId(id)
                                                    })
                                                });
                                                //console.log(response.message);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'An error occurred while uploading the image.',
                                                icon: 'error'
                                            });
                                        }
                                    });
                                }
                            }
                        }
                    }).then(() => {
                       fetchDataFromDB();//call function to make sure that the table displays the latest records

                        const currentUrl = new URL(window.location.href);// Create a new URL object from the current location
                        const newUrl = new URL('/vehicles/vehicle-table-view.php', window.location.origin);// Construct the new URL to be used
                        window.history.replaceState({}, '', newUrl.href);
                    });
                    
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Invalid response from server",
                        icon: "error"
                    }).then(() => {
                        $('#vehicleDataTable').show();
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Error",
                    text: "Unable to fetch images",
                    icon: "error"
                }).then(() => {
                    $('#dataTable').show();
                });
            }
        });
    }
    function printVehicleTable() {
        window.open("/vehicles/vehicle-print-view.php", "_blank");
    }
    // print table view
    // function printTable() {
    //     // Save the current column visibility states
    //     let table = $('#vehicleDataTable').DataTable();
    //     let columnVisibility = [];

    //     table.columns().every(function () {
    //         columnVisibility.push(this.visible());
    //     });

    //     // Show all columns
    //     table.columns().visible(true);

    //     // Hide everything except the table and its parent div
    //     $('body > *').not('.container-div').hide();

    //     // Get the table and its parent div
    //     var tableDiv = document.querySelector('.container-div');
    //     var tableElement = tableDiv.querySelector('table');

    //     // Hide the table footer
    //     $(tableElement).find('tfoot').hide();

    //     // Remove the action column temporarily
    //     var actionColumn = $(tableElement).find('th:last-child, td:last-child').detach();

    //     // Reduce font size for printing
    //     $(tableElement).css('font-size', '8px');

    //     // Create a copy of the table
    //     var tableClone = tableElement.cloneNode(true);

    //     // Create a title element
    //     var titleElement = document.createElement('h1');
    //     titleElement.innerText = "INVENTORY OF APPREHENDED/CONFISCATED DEPOSITED AT THE IMPOUNDING AREA OF PENRO LAGUNA \n\n";
    //     titleElement.style.textAlign = 'center';
    //     titleElement.style.fontSize = '12px';

    //     var printContainer = document.createElement('div');
    //     printContainer.appendChild(titleElement);
    //     printContainer.appendChild(tableClone);

    //     document.body.appendChild(printContainer);

    //     window.addEventListener('beforeprint', function () {
    //         console.log("Print initiated");
    //     });

    //     window.addEventListener('afterprint', function () {
    //         console.log("Print cancelled or completed");
    //         // Restore the original column visibility states
    //         table.columns().every(function (index) {
    //             this.visible(columnVisibility[index]);
    //         });

    //         // Refresh the page
    //         window.location.reload();
    //     });

    //     window.print();

    //     document.body.removeChild(printContainer);

    //     $(tableElement).css('font-size', '');

    //     $(tableElement).find('tfoot').show();

    //     // Restore the action column
    //     $(tableElement).find('thead tr').append(actionColumn.clone());
    //     $(tableElement).find('tbody tr').each(function () {
    //         $(this).append(actionColumn.clone());
    //     });
    // }
    //Add new record
    function redirectToUrl() {
         window.location.href = '/vehicles/add-record-view.php'; 
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<?php
include  "../templates/nav-bar2.php"; 
?>
</body>
</html>

