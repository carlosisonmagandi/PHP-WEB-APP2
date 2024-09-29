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
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- nav-bar -->
<link rel="stylesheet" type="text/css" href="/Styles/styles.css">
<link rel="stylesheet" type="text/css" href="/Styles/darkmode.css">

</head>
<body>
    <?php 
    include ("../templates/nav-bar.php");
    ?>

<style>
    * {
    box-sizing: border-box;
    }

    body {
    font-family: Arial, Helvetica, sans-serif;
    }

    .column {
    float: left;
    width: 25%;
    padding: 0 10px;
    }

    .row {margin: 0 -5px;}

    .row:after {
    content: "";
    display: table;
    clear: both;
    }

    /* Responsive columns */
    @media screen and (max-width: 600px) {
    .column {
        width: 100%;
        display: block;
        margin-bottom: 20px;
    }
   
    }

    /* Style the counter cards */
    .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    padding: 16px;
    text-align: center;
    background-color: #f1f1f1;
    margin: 10px 0;
    }

    /* custom card style */
    .totalItemDiv{
        background-color:#002f6c; 
        padding:5px; 
        position:absolute;
        right:2%;
        top:2%;
        font-size:10px;
        color:#FFF;
        border-radius:20%
    }
    
    .editButtonIcon{
        background-color:#003d7a;
        border:none; 
        position:absolute;
        right:6%;
        bottom:43%;
        font-size:10px;
        color:#fefefe;
        border-radius:20%;
       
    }
   
    .detailDiv{
        background-color:#003d7a;
        padding:5%;
        color:#f8f9fa;
        font-size:12px
    }
    .imageDiv{
        background-color:#FFF;
        
    }
    .img{
        width: 100%;
        height: 150px;
        object-fit: cover; 
        display: block; 
    }
    .button{
        background-color: #f8f9fa;
        color: #002f6c;
        border: 1px solid #002f6c;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-size: 11px;
        border-radius: 1px;
        padding:6px;
        width:40%;
    }
    .button:hover{
        background-color: #002f6c;
        color:#d1d1d1;  
    } 
    .flex-item-left {
    flex: 100%;
    }


    .flex-container .flex-item-right button:hover{
        background-color:#D3D3D3;
    } 
   
    </style>

    <!-- Scripts -->
    <!-- Note: It will not work inside header because of the php block for templates -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

<div class="flex-container">
    <div class="flex-item-left" id="titleContainer">
        <!-- title -->
         <br>
        <h3 style="font-size:12px; font-weight:bold"><center>INVENTORY OF APPREHENDED/CONFISCATED DEPOSITED AT THE IMPOUNDING AREA OF PENRO LAGUNA </ceter></h3>
    </div>
</div>

<!-- add new button -->
<button onclick="redirectToUrl()" class='btn btn-default' style="border:1px solid #e0e0e0; margin-left:20px;  ">
    Add New
</button>
<div class="container" style="overflow-y:scroll;height:450px;">
    <div class="row">
      <!-- dynamic values -->
    </div>
</div>
<script>
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
    $(document).ready(function() {
        
        // fetchTitleFromDB(); 
        var hasId = <?php echo json_encode($hasId); ?>;
        var id = <?php echo json_encode($id); ?>;

        if (hasId) {
            itemClickId(id);
        }else{
            fetchDataFromDB();
        };
      
    });

    function fetchDataFromDB() {
        $.ajax({
            url: '/equipments/get-equipment-and-image.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
            // console.log('Image response:', response);
            $('.container').empty();  // Clear existing content

            $.each(response, function(index, record) {
                var imagePath = record.file_path;
                var id=record.id
                var cardHtml = `
                    <div class="column">
                        <div class="card">
                            <div class="totalItemDiv">Condition: ${record.equipment_condition}</div>
                            <div class="innerCardContainer">
                                <div class="imageDiv">
                                    ${imagePath ? 
                                        `<img class="img" src="${imagePath}" alt="image">` : 
                                        `<div style="width: 100%; height: 150px; object-fit: cover; display: block;background: rgba(0, 0, 0, 0.6); color:#fefefe ">
                                            <br><br><br>
                                            <i class="fas fa-image"></i><span>&nbsp&nbsp</span>No image found.
                                        </div>
                                        `
                                    }
                                </div>
                                <div class="detailDiv">
                                    <button class="editButtonIcon" id="editButton" data-id=${record.id} >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a>${record.equipment_name}</a>
                                    <a>(${record.brand})</a>
                                    <p>${record.location}</p>
                                    <i><a>Confiscation Date:</a></i>
                                    <i><a>${record.date_of_compiscation}</a></i>
                                </div>
                                <br>
                                <div class="buttonsDiv">
                                    <input class="button" type="button" value="view location">
                                    <input class="button" id="moreDetails" data-id="${id}" type="button" value="more details">
                                </div>
                            </div>
                        </div>
                    </div>`;

                $('.container').append(cardHtml);
            });
        },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log(xhr.messageText);
                // Handle error gracefully, e.g., show an error message to the user
                alert("Error fetching data from the server. See console for details.");
            }
        });
    }

    $(document).ready(function() {
        $(document).on('click', '#moreDetails', function() {
            var id = $(this).data('id');  
            //hide the content
            itemClickId(id);
        });

        $(document).on('click', '#editButton', function() {
            var id = $(this).data('id');
            sessionStorage.setItem('viewType', 'card');
            let viewType = sessionStorage.getItem('viewType');
            editAction(id);  
        });

    });

    
    // function fetchTitleFromDB() {
    //     $.ajax({
    //         url: '/inventory-get-title.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(response) {
    //             // console.log('Title:', response);
    //             //alert(JSON.stringify(response));

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
    //             // Handle error gracefully, e.g., show an error message to the user
    //             alert("Error fetching data from the server. See console for details.");
    //         }
    //     });
    // }

    //Edit action
    function editAction(id) {
        $.ajax({
            url: '/equipments/get-edit-record.php',
            type: 'GET',
            data: { equipment_id: id },
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    // Construct query string with data
                    let queryString = id;
                    // console.log('test');
                    // console.log(queryString);

                    // Redirect with query parameters
                    window.location.href = '/equipments/add-record-view.php?' + queryString;
                } else {
                    Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
            }
        });
    }
 
    // more details
    function itemClickId(id) {
        //Image pane funtions
        $.ajax({
            url: '/equipments/equipment-get-images.php',
            type: 'GET',
            data: { equipment_id: id },
            dataType: 'json',
            success: function(response) { 
                  //console.log(response); 

                // Expected data
                if (response) {
                    // const barangay=response.barangay
                    // const title=response.apprehended_items;
                    // const sitio=response.sitio;
                    // const city_municipality=response.city_municipality;
                    // const province=response.province;
                    // const apprehending_officer=response.apprehending_officer;
                    // const EMV_forest_product=response.EMV_forest_product;
                    // const EMV_conveyance_implements=response.EMV_conveyance_implements;
                    // const involve_personalities=response.involve_personalities;
                    // const custodian=response.custodian;
                    // const ACP_status_or_case_no=response.ACP_status_or_case_no;
                    // const date_of_confiscation_order=response.date_of_confiscation_order;
                    // const remarks=response.remarks;
                    // const apprehended_persons=response.apprehended_persons;

                    // const apprehended_quantity=response.apprehended_quantity;
                    // const apprehended_volume=response.apprehended_volume;
                    // const apprehended_vehicle=response.apprehended_vehicle;
                    // const apprehended_vehicle_type=response.apprehended_vehicle_type;
                    // const apprehended_vehicle_plate_no=response.apprehended_vehicle_plate_no;

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
                                                <td>Test_Sitio</td>
                                                <td>Test_barangay</td>
                                                <td>Test_city</td>
                                                <td>Test_province</td>
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
                                                <td>Test_apprehending_officer</td>
                                                <td>Test_title</td>
                                                <td>Test_emv_forest_product</td>
                                                <td>Php. Test_EMV_conveyance_implements</td>
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
                                                <td>Test_involve_personalities</td>
                                                <td>Test_custodian</td>
                                                <td>Test_ACP_status_or_case_no</td>
                                                <td>Test_date_of_confiscation_order</td>
                                                <td>Test_remarks</td>
                                                <td>Test_apprehended_persons</td>
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
                                                <td>Test_apprehended_quantity</td>
                                                <td>Test_apprehended_volume</td>
                                                <td>Tet_apprehended_vehicle</td>
                                                <td>Test_apprehended_vehicle_type</td>
                                                <td>Test_apprehended_vehicle_plate_no</td>
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
                                        url: '/equipments/delete-image.php',
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
                                        url: '/equipments/upload-image.php',
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
                        const newUrl = new URL('/equipments/equipment-card-view.php', window.location.origin);// Construct the new URL to be used
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
    function redirectToUrl() {
         window.location.href = '/equipments/add-record-view.php'; 
    }
</script>

<?php
include  "../templates/nav-bar2.php"; 
?>
</body>
</html>
