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
  text-align: center;
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
        height:300px;
       
    }
    .container {
        width: 80%; 
        max-width: 600px; 
        border: 1px solid #ccc;
        padding: 20px;
    }
    .content {
        text-align: center;
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
<!-- nav-bar template -->

<?php 
include ("templates/nav-bar.php");
?>
<!--  -->
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
        <!-- <h3 style=" font-family: 'Poppins', sans-serif; font-size:12px; font-weight:bold">
            <center>
                100% INVENTORY OF APPREHENDED/CONFISCATED FOREST PRODUCT/CONVEYANCES <br>AND OTHER IMPLEMENTS DEPOSITED AT THE 
                IMPOUNDING AREA OF PENRO LAGUNA AS OF CY 2018-2024
            </center>
        </h3> -->
  </div>
  <div class="flex-item-right">
    <!-- <input type="file" id="fileInput" accept=".xls,.xlsx"> -->
    <!-- <button onclick="handleFile()" style="float:right">Load Data</button> -->

    <button onclick="redirectToUrl()" class='btn btn-default' style="border:1px solid #e0e0e0;  ">
        ( + )
    </button>

    <!-- Print icon button -->
    <button onclick="showFileUploadAlert()" class='btn btn-default' style="border:1px solid #e0e0e0;  ">
        <i class="bi bi-cloud-upload"></i> 
    </button>

    <!-- Print icon button -->
    <button onclick="printTable()" class='btn btn-default' style="border:1px solid #e0e0e0; margin-left: 5px;">
        <i class="bi bi-printer"></i> 
    </button>
  </div>
</div>




<div class="container-div" style="display: flex;flex-direction: column; margin-top:12px; font-size:10px;padding:10px">
    <div class="content" style="flex-grow: 1;overflow-x:scroll; ">
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

  
  //Get title details
  function fetchTitleFromDB() {
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

                callback(endYear);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle error gracefully, e.g., show an error message to the user
                alert("Error fetching data from the server. See console for details.");
            }
        });
    }

  function handleFile() {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];
    
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        const data = new Uint8Array(event.target.result);
        const workbook = XLSX.read(data, {type: 'array'});
        const sheetName = workbook.SheetNames[0];
        const sheet = workbook.Sheets[sheetName];
        const jsonData = XLSX.utils.sheet_to_json(sheet, {header: 1});
        
        displayJSON(jsonData); // Remove the header row
      };
      reader.onerror = function(event) {
        console.error("File could not be read! Code " + event.target.error.code);
      };
      reader.readAsArrayBuffer(file);
    } else {
      alert('Please select a file.');
    }
  }
  
  function displayJSON(data) {
        const headers = [
            'date_of_apprehension',
            'sitio',
            'barangay',
            'city_municipality',
            'province',
            'apprehending_officer',
            'apprehended_items',
            'EMV_forest_product',
            'EMV_conveyance_implements',
            'involve_personalities',
            'custodian',
            'ACP_status_or_case_no',
            'date_of_confiscation_order',
            'remarks',
            'apprehended_persons'
        ]; // Hardcoded headers
        const jsonData = [];
        data.forEach(row => {
            const obj = {};
            headers.forEach((header, index) => {
                obj[header] = row[index] || ''; // Ensure that missing values are handled gracefully
            });
            jsonData.push(obj);
        });
        const jsonString = JSON.stringify(jsonData, null, 2);
        // alert(jsonString);
        sendData(jsonData);
    }

function sendData(data) {
    const jsonData = JSON.stringify(data);
    $.ajax({
        url: '/inventory-insert-data.php',
        type: 'POST',
        contentType: 'application/json',
        data: jsonData,
        success: function(response) {
            console.log('Success:', response);
            fetchDataFromDB();
            // alert("Data inserted successfully.");
            success();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert("Error inserting data. See console for details.");
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
            // Handle the response data here, e.g., update your HTML table
            updateTable(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            // Handle error gracefully, e.g., show an error message to the user
            alert("Error fetching data from the server. See console for details.");
        }
    });
}

function updateTable(data) {
    const table = $('#dataTable').DataTable();
    
    // Clear the existing data from the DataTable
    table.clear();
    
    // Add new data
    data.forEach(rowData => {
        // Create an array to hold cell values for this row
        const rowDataArray = [];
        
        // Loop through each value in the rowData object and push it into the array
        Object.values(rowData).forEach(value => {
            rowDataArray.push(value);
        });
        
        // Add the action column button to the end of the row
        const id = rowData['id'];
         //rowDataArray.push('<button onclick="action(event)" class="btn btn-default" type="button" aria-expanded="false" ><i class="bi bi-three-dots"></i></button>');
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
         // Add the row to the DataTable
        table.row.add(rowDataArray);
    });
    
    // Redraw the DataTable
    table.order([16, 'desc']).draw();
}

// Call fetchDataFromDB() when the page loads
$(document).ready(function() {
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

    function showFileUploadAlert() {
      // Create a file input element
      const fileInput = document.createElement('input');
      fileInput.type = 'file';
      fileInput.id = 'fileInput';
      fileInput.accept = '.xls,.xlsx';

      // Create a label for the file input
      const fileInputLabel = document.createElement('label');
      fileInputLabel.textContent = '';
      fileInputLabel.htmlFor = 'fileInput';

      // Create a SweetAlert dialog with custom HTML
      Swal.fire({
        title: 'Upload File (.xls,.xlsx)',
        html: fileInputLabel.outerHTML + fileInput.outerHTML,
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonText: 'Load Data',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
          // Access the file uploaded by the user (if any)
          const file = fileInput.files[0];
          // Handle the uploaded file here
          console.log('Uploaded file:', file);
          // Call handleFile function
          handleFile();
        }
      });
    }

//Fetching id using eventlistener instead of onlick 
$(document).ready(function() {
    //get title details on page load
    fetchTitleFromDB();

    //Call function for click ID
    clickableId()

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
                let htmlContent = `<h2>${response.apprehended_items}</h2>`;
                if (response.images.length > 0) {
                    response.images.forEach(function(image) {
                        htmlContent += `
                        <style>
                        .flex-container {
                            display: flex;
                            flex-direction: row; 
                            text-align: center;
                        }

                        .flex-item-left-img {
                            background-color: #f1f1f1;
                            flex: 1; 
                            margin: 5px; 
                        }

                        .flex-item-left-img img {
                            max-height: 100px;
                            width: auto; 
                        }
                        </style>
                        <div>    
                            <div class="flex-container">
                                <div class="flex-item-left-img">
                                    <img src="${image.file_path}" alt="${image.file_name}" style="max-height: 100px;">
                                </div> 
                            </div>
                        </div>`;
                    });
                } else {
                    htmlContent +=`
                    <style>
                    .flex-container {
                        display: flex;
                        flex-direction: row; 
                        text-align: center;
                    }

                    .flex-item-left-img {
                        // background-color: #f1f1f1;
                        flex: 1; 
                        margin: 5px; 
                        position: relative; /* Position relative to enable absolute positioning for hover effect */
                    }

                    .flex-item-left-img img {
                        max-height: 100px;
                        width: auto; 
                    }

                    .flex-item-left-img .hover-text {
                        display: none;
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.6); /* Transparent black background */
                        color: white;
                        align-items: center;
                        justify-content: center;
                        text-align: center;
                        font-size: 16px;
                        cursor: pointer;
                    }

                    .flex-item-left-img:hover .hover-text {
                        display: flex; /* Show the text on hover */
                    }
                    </style>
                    <div>    
                        <div class="flex-container">
                            <div class="flex-item-left-img">
                                <img src="images/log-default-image.jpg" alt="Default Image" style="max-height: 100px;">
                                <div class="hover-text">UPDATE ME</div>
                            </div> 
                        </div>
                    </div>`;
                }

                Swal.fire({
                    title: "Success.",
                    text: `Inventory ID: ${id}`,
                    html: htmlContent
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Invalid response from server",
                    icon: "error"
                });
            }
        },
        error: function() {
            Swal.fire({
                title: "Error",
                text: "Unable to fetch images",
                icon: "error"
            });
        }
    });
}


// print table view
function printTable() {
    // Hide everything except the table and its parent div
    $('body > *').not('.container-div').hide();
    
    // Get the table and its parent div
    var tableDiv = document.querySelector('.container-div');
    var table = tableDiv.querySelector('table');
    
    // Hide the table footer
    $(table).find('tfoot').hide();
    
    // Remove the action column temporarily
    var actionColumn = $(table).find('th:last-child, td:last-child').detach();
    
    // Reduce font size for printing
    $(table).css('font-size', '8px');
    
    // Create a copy of the table
    var tableClone = table.cloneNode(true);

    // Create a title element
    var titleElement = document.createElement('h1');
    titleElement.innerText = "APPREHENDED/CONFISCATED FOREST PRODUCT/CONVEYANCES AND OTHER IMPLEMENTS DEPOSITED AT THE IMPOUNDING AREA OF PENRO LAGUNA \n\n";
    titleElement.style.textAlign = 'center';
    titleElement.style.fontSize = '12px';

    var printContainer = document.createElement('div');
    printContainer.appendChild(titleElement);
    printContainer.appendChild(tableClone);

    document.body.appendChild(printContainer);
    
    window.addEventListener('beforeprint', function() {
        console.log("Print initiated");
    });

    window.addEventListener('afterprint', function() {
        console.log("Print cancelled or completed");
        // Refresh the page
        window.location.reload();
    });

    window.print();
    
    document.body.removeChild(printContainer);
    
    $(table).css('font-size', ''); 
    
    $('body > *').show();
    
    $(table).find('tfoot').show();
    
    $(table).find('thead tr').append("<th>ACTIONS</th>");
    $(table).find('tbody tr').each(function() {
        $(this).append("<td></td>");
    });
}


//Add new record
    function redirectToUrl() {
         window.location.href = '/inventory-add-record.php'; 
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<?php
include  "templates/nav-bar2.php"; 
?>
</body>
</html>

