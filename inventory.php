<?php
session_start();
require("includes/session.php");
require("includes/darkmode.php");
require("includes/authentication.php");


//action after logout button
if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: ../../index.php");
    exit;
};
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
    flex: 20%;
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
    @media (max-width: 800px) {
    .flex-container {
        flex-direction: column;
    }
    } 
</style>
</head>
<body>
<?php 
include ("templates/nav-bar.php");
?>
<br>

<!-- Scripts -->
<!-- Note: It will not work inside header because of the php block for templates -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<!-- data table -->
<script src="Styles/data-table/jquery-3.7.1.js"></script>
<script src="Styles/data-table/dataTables.js"></script>
<link href="Styles/data-table/dataTables.css" rel="stylesheet" />

<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

<div class="flex-container">
  <div class="flex-item-left" id="titleContainer">
        <!-- title -->
  </div>
  <div class="flex-item-right">
    <!-- <input type="file" id="fileInput" accept=".xls,.xlsx"> -->
    <!-- <button onclick="handleFile()" style="float:right">Load Data</button> -->

    <button onclick="redirectToUrl()" class='btn btn-default' style="border:1px solid #e0e0e0;  ">
        ( + )
    </button>

    <!-- Print icon button -->
    <button onclick="printTable()" class='btn btn-default' style="border:1px solid #e0e0e0; margin-left: 5px;">
        <i class="bi bi-printer"></i> 
    </button>
  </div>
</div>

<div class="container-div" style="display: flex;flex-direction: column; margin-top:12px; font-size:10px;padding:10px">
    <div class="content" style="flex-grow: 1; overflow-x:scroll" ><!--Removed overflow-x:scroll; -->
        <!-- overflow-x:scroll; -->
        <table id="dataTable" class="display" style="width:100%; border:1px solid black; font-size=10px;" >
        <thead style="text-align:center; " >
        <tr>
            <th style="width:10%;">ID</th>
            <th>Date of Apprehension</th>
            <th>SITIO</th>
            <th>BARANGAY</th>
            <th>CITY/MUNICIPALITY</th>
            <th>PROVINCE</th>
            <th>APPREHENDING OFFICER</th>
            <th>APPREHENDED ITEMS(Species,Pieces,Volume,Conveyance,Implements, etc.)</th>
            <th>ESTIMATED MARKET VALUE OF FOREST PRODUCTS</th>
            <th>ESTIMATED VALUE OF CONVEYANCE & IMPLEMENTS</th>
            <th>INVOLVE PERSONALITIES</th>
            <th>CUSTODIAN</th>
            <th>acp STATUS/ CASES NO.</th>
            <th>DATE OF CONFISCATION ORDER</th>
            <th>REMARKS(Status of apprehended Item)</th>
            <th>APPREHENDED PERSON</th>
            <th>DATE CREATED</th>
            
            <th>ACTIONS</th>
        </tr>
        </thead>
        <tbody id="dataBody" style="text-align:center;">
        </tbody>

        <tfoot>
            <tr>
                <th style="width:10%;">ID</th>
                <th>Date of Apprehension</th>
                <th>SITIO</th>
                <th>BARANGAY</th>
                <th>CITY/MUNICIPALITY</th>
                <th>PROVINCE</th>
                <th>APPREHENDING OFFICER</th>
                <th>APPREHENDED ITEMS(Species,Pieces,Volume,Conveyance,Implements, etc.)</th>
                <th>ESTIMATED MARKET VALUE OF FOREST PRODUCTS</th>
                <th>ESTIMATED VALUE OF CONVEYANCE & IMPLEMENTS</th>
                <th>INVOLVE PERSONALITIES</th>
                <th>CUSTODIAN</th>
                <th>acp STATUS/ CASES NO.</th>
                <th>DATE OF CONFISCATION ORDER</th>
                <th>REMARKS(Status of apprehended Item)</th>
                <th>APPREHENDED PERSON</th>
                <th>DATE CREATED</th>
                <th >ACTIONS</th>
            </tr>
        </tfoot>
        </table>
    </div>
</div>

<script>
  let tableData = [];
  let currentPage = 1;
  const pageSize = 5;

  new DataTable('#dataTable', {
    initComplete: function () {
        this.api().column(2).visible(false);//hide the SITIO column
        this.api().column(6).visible(false);//hide the Apprehending Officer column
        this.api().column(8).visible(false);//hide the Estimated marketvalue column
        this.api().column(9).visible(false);//hide the Estimated value of conveyance column
        this.api().column(10).visible(false);//hide the Involve personalities column
        this.api().column(11).visible(false);//hide the Customdian column
        this.api().column(12).visible(false);//hide the ACP case No column
        this.api().column(13).visible(false);//hide the Date of confiscation order column
        this.api().column(14).visible(false);//hide the Remarks column
        this.api().column(15).visible(false);//hide the Apprehended person column
        this.api().column(16).visible(false);//hide the Date created column
        this.api()
            .columns()
            .every(function () {
                let column = this;
                let title = column.footer().textContent;
 
                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);
 
                // Event listener for user input
                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
        }
    });
  function fetchTitleFromDB() {//Get title details
        $.ajax({
            url: '/inventory-get-title.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Title:', response);
                //alert(JSON.stringify(response));
                var percent = response[0].percentage;
                var title = response[0].title;
                var startYear = response[0].cy_start_year; 
                var endYear = response[0].cy_end_year;

                var dynamicContent = percent + "% INVENTORY OF " + title.toUpperCase() + " AS OF CY " + startYear + "-" +  
                `<select name="endYear" id="endYear" >
                    <option >2019</option>
                    <option >2020</option>
                    <option >2021</option>
                    <option >2022</option>
                    <option >2023</option>
                    <option selected>${endYear}</option>
                    <option >2025</option>
                    <option >2026</option>
                    <option >2027</option>
                    <option >2028</option>
                    <option >2029</option>
                    <option >2030</option>
                </select>` ;
                document.getElementById("titleContainer").innerHTML = '<h3 style="font-family: \'Poppins\', sans-serif; font-size:12px; font-weight:bold"><center>' + dynamicContent + '</center></h3>';
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle error gracefully, e.g., show an error message to the user
                alert("Error fetching data from the server. See console for details.");
            }
        });
    }

    function fetchDataFromDB() {
        $.ajax({
            url: '/inventory-get-data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Success:', response);
                updateTable(response);//call updateTable
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert("Error fetching data from the server. See console for details.");
            }
        });
    }

    function updateTable(data) {
        const table = $('#dataTable').DataTable();
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
                    <li><a class="dropdown-item qr-action">Add Specs<i class="fas fa-qrcode" style="float:right"></i></a></li>
                </ul>
            </div>
            `);
            table.row.add(rowDataArray);// Add the row to the DataTable
        });
        table.order([16, 'desc']).draw();// Redraw the DataTable
    }

    $(document).ready(function() {//call fetchDataFromDb on page load
        fetchDataFromDB();
    });

    //Adding Action column at the end

    // Custom sweet alert
    function success(){
        Swal.fire({
            title: "Success.",
            text:"Data inserted successfully.",
            icon:"success"

        });
    }

    //qr sweet alert modal
    function generateQrModal(id){
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
        title: "Unable to generate QR",
        text: "No coordinates value found. Do you want to update the record?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, add location!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
        }).then((result) => {
        // if (result.isConfirmed) {
        //     swalWithBootstrapButtons.fire({
        //     title: "Success",
        //     text: "QR generated successfully",
        //     icon: "success"
        //     });
        // }
        if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({
            title: "Set pin location",
            confirmButtonText: "Done",
            html: 
                `<div class="main-map-container">
                    <div class="container">
                        <div class="content">
                        <div id="coordinates" class="coordinates">
                            <p>Latitude: 120.9842</p>
                            <p>Latitude: 14.5995</p>
                        </div>
                        <iframe width="100%" height="1200px" src="https://maps.google.com/maps?width=100%&amp;&amp;hl=en&amp;coord=14.1755,121.2413&amp;q=Los%20Ba%C3%B1os%2C%20Lalakay%2C%20Laguna%2C%20Philippines&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><br />
                        </div>
                    </div>
                </div>`
            }).then((innerResult) => {
                if (innerResult.isConfirmed) {
                    // Call function here or modal
                   alert("Actions:\n1.Run Update query on specific record to add the coordinate value.\n2. show success modal for generated QR");
                }
            });
        }else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
            title: "Cancelled",
            text: "No QR has been generate",
            icon: "error"
            });
        }
        });
    }

    //Fetching id using eventlistener instead of onlick 
    $(document).ready(function() {
        fetchTitleFromDB();//get title details on page load
        clickableId()//Call function for click ID

        // Event listener for edit action
        $('#dataTable').on('click', '.edit-action', function() {
            const id = $(this).closest('tr').find('td:first').text();
            editAction(id);
        });

        // Event listener for delete action
        $('#dataTable').on('click', '.delete-action', function() {
            const id = $(this).closest('tr').find('td:first').text();
            deleteAction(id);
        });

        // Event listener for generate QR
        $('#dataTable').on('click', '.qr-action', function() {
            const id = $(this).closest('tr').find('td:first').text();
            generateQrAction(id);
        });
    });

    function editAction(id) {
        alert('Edit successful for ID: ' + id);
    }

    function deleteAction(id) {
        alert('Delete successful for ID: ' + id);
    }

    function generateQrAction(id) {
        //alert('QR ID: ' + id);
        generateQrModal(id);
    }

    function clickableId(){
        //clickable id
        $('#dataTable').on('click', '.clickable-id', function() {
            //alert('You clicked on id: ' + $(this).text());
            var id = $(this).text();
            $('#dataTable').hide();
            itemClickId(id);
        });
    }

    function itemClickId(id) {
        $.ajax({
            url: '/inventory-get-images.php',
            type: 'GET',
            data: { inventory_id: id },
            dataType: 'json',
            success: function(response) { 
                console.log(response); // Log the response to help debug

                // Expected data
                if (response && response.apprehended_items && response.images) {
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
                                        <img src="${image.file_path}" alt="${image.file_name}" style="max-height: 180px;max-width:180px;border:1px solid gray">
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
                                    <div class="hover-text">No image found</div>
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
                                height:100%;
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
                                background-color: #002f6c;
                                color: white;
                                font-size: 18px;
                            }
                            .sub-category-header {
                                background-color: #002f6c;
                                color: white;
                                font-size: 16px;
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
                                <input type="button" value="Add Image" class="addImageButton" />
                                ${htmlContent}
                            </div>
                            <div class="flex-container-right">
                                <br>
                                <div class="grid-container">
                                    <div class="grid-item item1">
                                        <table>
                                            <tr>
                                                <th colspan="4" class="sub-category-header">Apprehension Site</th>
                                            </tr>
                                            <tr>
                                                <td><b>SITIO</b></td>
                                                <td><b>BARANGAY</b></td>
                                                <td><b>City</b></td>
                                                <td><b>Province</b></td>
                                            </tr>
                                            <tr>
                                                <td>N/A</td>
                                                <td>Bucal</td>
                                                <td>Calamba</td>
                                                <td>Laguna</td>
                                            </tr>
                                        </table>
                                    </div>  
                                    <div class="grid-item item2">
                                        <table>
                                            <tr>
                                                <th colspan="4" class="sub-category-header">Apprehension Details</th>
                                            </tr>
                                            <tr>
                                                <td><b>Apprehending Officer</b></td>
                                                <td><b>Apprehended Items</b></td>
                                                <td><b>EMV Forest Product</b></td>
                                                <td><b>EMV Conveyance Implements</b></td>
                                            </tr>
                                            <tr>
                                                <td>John</td>
                                                <td>Mahogany logs,4pcs,1.871 cu.m(Ten Wheeler Truck with Plate No. ADK-4398)</td>
                                                <td>N/A</td>
                                                <td>N/A</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="grid-item item3">
                                        <table>
                                            <tr>
                                                <th colspan="6" class="category-header">Case Information</th>
                                            </tr>
                                            <tr>
                                                <td><b>Involve Personalities</b></td>
                                                <td><b>Custodian</b></td>
                                                <td><b>ACP Status or Case No</b></td>
                                                <td><b>Date of Confiscation Order</b></td>
                                                <td><b>Remarks</b></td>
                                                <td><b>Apprehended Person</b></td>
                                            </tr>
                                            <tr>
                                                <td>ED Regional Office</td>
                                                <td>Chief, EMS PENRO Lag.</td>
                                                <td>Final report submitted to R.O dated 07/11/2019</td>
                                                <td>07/11/2019</td>
                                                <td>Confiscated forest Product</td>
                                                <td>Joe</td>
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
                            document.querySelector('.swal2-popup').style.height = '100%';
                            document.querySelectorAll('.delete-button').forEach(button => {
                                button.addEventListener('click', function() {
                                    let buttonId = this.getAttribute('data-id');
                                    $.ajax({
                                        url: '/inventory-tree/delete-image.php',
                                        type: 'POST',
                                        data: { image_id: buttonId },
                                        dataType: 'json',
                                        success: function(response) {
                                            if (response.success) {
                                                $('#dataTable').show();//reload the table before the success modal
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
                        }
                    }).then(() => {
                        $('#dataTable').show();
                    });
                    
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Invalid response from server",
                        icon: "error"
                    }).then(() => {
                        $('#dataTable').show();
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




    // print table view
    function printTable() {
        // Save the current column visibility states
        let table = $('#dataTable').DataTable();
        let columnVisibility = [];

        table.columns().every(function () {
            columnVisibility.push(this.visible());
        });

        // Show all columns
        table.columns().visible(true);

        // Hide everything except the table and its parent div
        $('body > *').not('.container-div').hide();

        // Get the table and its parent div
        var tableDiv = document.querySelector('.container-div');
        var tableElement = tableDiv.querySelector('table');

        // Hide the table footer
        $(tableElement).find('tfoot').hide();

        // Remove the action column temporarily
        var actionColumn = $(tableElement).find('th:last-child, td:last-child').detach();

        // Reduce font size for printing
        $(tableElement).css('font-size', '8px');

        // Create a copy of the table
        var tableClone = tableElement.cloneNode(true);

        // Create a title element
        var titleElement = document.createElement('h1');
        titleElement.innerText = "APPREHENDED/CONFISCATED FOREST PRODUCT/CONVEYANCES AND OTHER IMPLEMENTS DEPOSITED AT THE IMPOUNDING AREA OF PENRO LAGUNA \n\n";
        titleElement.style.textAlign = 'center';
        titleElement.style.fontSize = '12px';

        var printContainer = document.createElement('div');
        printContainer.appendChild(titleElement);
        printContainer.appendChild(tableClone);

        document.body.appendChild(printContainer);

        window.addEventListener('beforeprint', function () {
            console.log("Print initiated");
        });

        window.addEventListener('afterprint', function () {
            console.log("Print cancelled or completed");
            // Restore the original column visibility states
            table.columns().every(function (index) {
                this.visible(columnVisibility[index]);
            });

            // Refresh the page
            window.location.reload();
        });

        window.print();

        document.body.removeChild(printContainer);

        $(tableElement).css('font-size', '');

        $(tableElement).find('tfoot').show();

        // Restore the action column
        $(tableElement).find('thead tr').append(actionColumn.clone());
        $(tableElement).find('tbody tr').each(function () {
            $(this).append(actionColumn.clone());
        });
    }

    //Add new record
    function redirectToUrl() {
         window.location.href = '/inventory-tree/add-record-view.php'; 
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<?php
include  "templates/nav-bar2.php"; 
?>
</body>
</html>

