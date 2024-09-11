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
<div class="mainContaier" >
    <div class="flex-container">
        <div class="flex-item-left" id="titleContainer">
            <!-- title -->
            <h3 style="font-size:12px; font-weight:bold"><center>100% INVENTORY OF APPREHENDED/CONFISCATED FOREST PRODUCT/CONVEYANCES AND OTHER IMPLEMENTS<br> DEPOSITED AT THE IMPOUNDING AREA OF PENRO LAGUNA </ceter></h3>
        </div>
        <div class="flex-item-right">
            <button onclick="redirectToUrl()" class='btn btn-default' id="addNewButton" style="border:1px solid #e0e0e0;box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); font-size:12px; padding:9px;  ">
                Add New
            </button>

            <!-- Print icon button -->
            <button onclick="printTable()" class='btn btn-default' id="printTableButton" style="border:1px solid #e0e0e0; margin-left: 5px;box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
                <i class="bi bi-printer"></i> 
            </button>
        </div>
    </div>

    <div class="container-div" style="display: flex;flex-direction: column; margin-top:12px; font-size:10px;padding:10px">
        <div class="content" style="flex-grow: 1; " ><!--Removed overflow-x:scroll; -->
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

</div>


<script>
    let tableData = [];
    let currentPage = 1;
    const pageSize = 5;

    new DataTable('#dataTable', {
        initComplete: function () {
            const api = this.api();

            // Hide columns in a single operation
            api.columns([2, 6, 8, 9, 10, 11, 12, 13, 14, 15, 16])
                .visible(false);

            api.columns().every(function (index) { 
                const column = this;
                const footer = column.footer();

                if (index !== 17) { 
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

    // function fetchTitleFromDB() {//Get title details
    //     $.ajax({
    //         url: '/inventory-get-title.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(response) {
    //             var percent = response[0].percentage;
    //             var title = response[0].title;
    //             var startYear = response[0].cy_start_year; 
    //             var endYear = response[0].cy_end_year;

    //             var dynamicContent = percent + "% INVENTORY OF " + title.toUpperCase() 
    //             // + " AS OF CY "
    //             //  + startYear + "-"
    //             +  
    //             `<select name="endYear" id="endYear" >
    //                 <option selected>${endYear}</option>
    //                 <option >2025</option>
    //                 <option >2026</option>
    //                 <option >2027</option>
    //                 <option >2028</option>
    //                 <option >2029</option>
    //                 <option >2030</option>
    //                 <option >2031</option>
    //                 <option >2032</option>
    //                 <option >2033</option>
    //                 <option >2034</option>
    //                 <option >2035</option>
    //                 <option >2036</option>
    //                 <option >2037</option>
    //                 <option >2038</option>
    //                 <option >2039</option>
    //                 <option >2040</option>
    //             </select>` ;
    //             document.getElementById("titleContainer").innerHTML = '<h3 style="font-family: \'Poppins\', sans-serif; font-size:12px; font-weight:bold"><center>' + dynamicContent + '</center></h3>';
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Error:', error);
    //             alert("Error fetching data from the server. See console for details.");
    //         }
    //     });
    // }

    function fetchDataFromDB() {
        $.ajax({
            url: '/inventory-get-data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // console.log('Success:', response);
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
                    <!--<li><a class="dropdown-item qr-action">Add Specs<i class="fas fa-qrcode" style="float:right"></i></a></li>-->
                </ul>
            </div>
            `);
            table.row.add(rowDataArray);// Add the row to the DataTable
        });
        table.order([16, 'desc']).draw();// Redraw the DataTable
    }

    $(document).ready(function() {//call fetchDataFromDb on page load
        var hasId = <?php echo json_encode($hasId); ?>;
        var id = <?php echo json_encode($id); ?>;

        if (hasId) {
            itemClickId(id);
        }else{
            fetchDataFromDB();
        };
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
        //fetchTitleFromDB();//get title details on page load
        clickableId()//Call function for click ID

        // Event listener for edit action
        $('#dataTable').on('click', '.edit-action', function() {
            const id = $(this).closest('tr').find('td:first').text();
            sessionStorage.setItem('viewType', 'table');
            let viewType = sessionStorage.getItem('viewType');
            editAction(id);
        });

        // Event listener for delete action
        $('#dataTable').on('click', '.delete-action', function() {
            const id = $(this).closest('tr').find('td:first').text();
            deleteAction(id);
        });

        // Event listener for generate QR
        // $('#dataTable').on('click', '.qr-action', function() {
        //     const id = $(this).closest('tr').find('td:first').text();
        //     generateQrAction(id);
        // });
    });

    //Edit function
    function editAction(id) {
        $.ajax({
            url: '/inventory-tree/get-record.php',
            type: 'GET',
            data: { inventory_id: id },
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    // Construct query string with data
                    let queryString = id;
                    // console.log('test');
                    // console.log(queryString);

                    // Redirect with query parameters
                    window.location.href = '/inventory-tree/add-record-view.php?' + queryString;
                } else {
                    Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
            }
        });
    }


    function deleteAction(id) {
        // alert('Delete successful for ID: ' + id);

        $.ajax({
            url: '/inventory-tree/delete-record.php',
            type: 'POST',
            data: { inventory_id: id },
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

    // function generateQrAction(id) {
    //     //alert('QR ID: ' + id);
    //     generateQrModal(id);
    // }

    function clickableId(){
        //clickable id
        $('#dataTable').on('click', '.clickable-id', function() {
            //alert('You clicked on id: ' + $(this).text());
            var id = $(this).text();
            itemClickId(id);
        });
    }

    function itemClickId(id) {
        //Image pane funtions
        $.ajax({
            url: '/inventory-get-images.php',
            type: 'GET',
            data: { inventory_id: id },
            dataType: 'json',
            success: function(response) { 
                // console.log('here');
                //  console.log(response); // Log the response to help debug

                // Expected data
                if (response) {
                    const barangay=response.barangay
                    const title=response.apprehended_items;
                    const sitio=response.sitio;
                    const city_municipality=response.city_municipality;
                    const province=response.province;
                    const apprehending_officer=response.apprehending_officer;
                    const EMV_forest_product=response.EMV_forest_product;
                    const EMV_conveyance_implements=response.EMV_conveyance_implements;
                    const involve_personalities=response.involve_personalities;
                    const custodian=response.custodian;
                    const ACP_status_or_case_no=response.ACP_status_or_case_no;
                    const date_of_confiscation_order=response.date_of_confiscation_order;
                    const remarks=response.remarks;
                    const apprehended_persons=response.apprehended_persons;

                    const apprehended_quantity=response.apprehended_quantity;
                    const apprehended_volume=response.apprehended_volume;
                    const apprehended_vehicle=response.apprehended_vehicle;
                    const apprehended_vehicle_type=response.apprehended_vehicle_type;
                    const apprehended_vehicle_plate_no=response.apprehended_vehicle_plate_no;

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
                                <input type="button" value="Add Image" class="addImageButton" id="addImage" />
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
                                                <td>${sitio}</td>
                                                <td >${barangay}</td>
                                                <td>${city_municipality}</td>
                                                <td>${province}</td>
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
                                                <td>${apprehending_officer}</td>
                                                <td>${title}</td>
                                                <td>${EMV_forest_product}</td>
                                                <td>Php. ${EMV_conveyance_implements}</td>
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
                                                <td>${involve_personalities}</td>
                                                <td>${custodian}</td>
                                                <td>${ACP_status_or_case_no}</td>
                                                <td>${date_of_confiscation_order}</td>
                                                <td>${remarks}</td>
                                                <td>${apprehended_persons}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="grid-item item4">
                                        <table>
                                            <tr>
                                                <th colspan="6" class="category-header">Apprehension Metrics</th>
                                            </tr>
                                            <tr>
                                                <td><b>Quantity</b></td>
                                                <td><b>Volume</b></td>
                                                <td><b>Vehicle</b></td>
                                                <td><b>Type of vehicle</b></td>
                                                <td><b>Plate #</b></td>
                                            </tr>
                                            <tr>
                                                <td>${apprehended_quantity}</td>
                                                <td>${apprehended_volume}</td>
                                                <td>${apprehended_vehicle}</td>
                                                <td>${apprehended_vehicle_type}</td>
                                                <td>${apprehended_vehicle_plate_no}</td>
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
                                        url: '/inventory-tree/delete-image.php',
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
                            const buttonAddImage = document.getElementById('addImage');
                            buttonAddImage.addEventListener('click', addImage);

                            function addImage() {
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
                                        url: '/inventory-tree/upload-image.php',
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
                        const newUrl = new URL('/inventory.php', window.location.origin);// Construct the new URL to be used
                        window.history.replaceState({}, '', newUrl.href);
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

