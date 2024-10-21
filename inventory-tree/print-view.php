<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Product Apprehension Record</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 10px;
            background-color: #f4f4f4;
            
            justify-content: center; /* Center horizontally */
            align-items: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        /* removed td below */
        th {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        td{
            border: 1px solid #919191;
            text-align:center;
        }
        th {
            background-color: #002d72;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .pagination {
            margin-top: 10px;
            text-align: center;
        }
        .page-btn {
            margin: 0 5px;
            cursor: pointer;
            padding: 5px 10px;
            background-color: #002d72;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .page-btn:hover {
            background-color: #001e4d;
        }

        .print-button{
            margin: 0 5px;
            cursor: pointer;
            padding: 5px 10px;
            background-color: #002d72;
            color: white;
            border: none;
            border-radius: 5px;
            font-size:12px;
            height:30px;
        }
        
        .parent {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 8px;
        }
        .div3{text-align:right;}
            

                
      

    </style>
    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        @media print {
            .pagination, .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <center><b><h2>INVENTORY OF APPREHENDED/CONFISCATED FOREST PRODUCTS AT THE IMPOUNDING AREA OF PENRO LAGUNA</h2></b></center>
    <table id="recordTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name of Respondent/Claimant/Owner</th>
                <th>Date of Apprehension</th>
                <th>Apprehending Officer</th>
                <th colspan="7">Forest Product Description</th>
                <th colspan="4">Conveyance</th>
                
                <th>Administrative Status</th>
                <th>Remarks</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Quantity (pcs)</th>
                <th>Volume bd. ft.</th>
                <th>Linear mtrs</th>
                <th>Estimated Value (₱)</th>
                <th>Type/Kind (Species)</th>
                <th>Place of Depository</th>
                <th>Place of Apprehension</th>
                <th>Vehicle/Brand</th>
                <th>Type of Vehicle</th>
                <th>Plate #</th>
                <th>Conveyance Estimated Val. (₱)</th>
                <th></th>
                <th></th>
                
            </tr>
        </thead>
        <tbody id="recordBody">
            <!-- Sample records will be populated by JavaScript -->
        </tbody>
    </table>
    <br>
    
            
    
    <div class="parent">
        <div class="div1">
            
        </div>
        <div class="div2">
            <div class="pagination" id="pagination"></div>
        </div>
        <div class="div3">
            <button class="print-button" onclick="window.print()"> 
                <i class="fas fa-print"></i>
                Print
            </button>
        </div>
    </div>
             
    <script>
        $(document).ready(function() { 
        $.ajax({
            url: '/inventory-tree/get-all-record.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    let records = data.data; 
                    const recordsPerPage = 10; 
                    let currentPage = 1;
                    const totalPages = Math.ceil(records.length / recordsPerPage);

                    // Function to display records on the current page
                    function displayRecords(page) {
                        const startIndex = (page - 1) * recordsPerPage;
                        const endIndex = startIndex + recordsPerPage;
                        const paginatedRecords = records.slice(startIndex, endIndex);

                        const recordBody = document.getElementById('recordBody');
                        recordBody.innerHTML = ''; 

                        paginatedRecords.forEach(record => {
                            const row = `
                                <tr>
                                    <td>${record.id}</td>
                                    <td>${record.involve_personalities}</td>
                                    <td>${record.date_of_apprehension}</td>
                                    <td>${record.apprehending_officer}</td>
                                    <td>${record.apprehended_quantity}</td>
                                    <td>${record.apprehended_volume}</td>
                                    <td>${record.linear_mtrs}</td>
                                    <td>${record.EMV_forest_product}</td>
                                    <td>${record.apprehended_items}</td>
                                    <td>${record.depository_sitio} ${record.depository_barangay}, ${record.depository_city} ${record.depository_province}</td>
                                    <td>${record.sitio} ${record.barangay}, ${record.city_municipality} ${record.province}</td>
                                    <td>${record.apprehended_vehicle}</td>
                                    <td>${record.apprehended_vehicle_type}</td>
                                    <td>${record.apprehended_vehicle_plate_no}</td>
                                    <td>${record.EMV_conveyance_implements}</td>
                                    <td>${record.ACP_status_or_case_no}</td>
                                    <td>${record.remarks}</td>
                                </tr>
                            `;
                            recordBody.innerHTML += row;
                        });
                    }

                    // Function to setup pagination with arrows
                    function setupPagination() {
                        const paginationDiv = document.getElementById('pagination');
                        paginationDiv.innerHTML = ''; 

                        // Previous button
                        const prevButton = document.createElement('button');
                        prevButton.classList.add('page-btn');
                        prevButton.innerText = 'Previous';
                        prevButton.disabled = currentPage === 1;
                        prevButton.onclick = () => {
                            if (currentPage > 1) {
                                currentPage--;
                                displayRecords(currentPage);
                                setupPagination();
                            }
                        };
                        paginationDiv.appendChild(prevButton);

                        // Display current page info
                        const pageInfo = document.createElement('span');
                        pageInfo.innerText = ` Page ${currentPage} of ${totalPages} `;
                        paginationDiv.appendChild(pageInfo);

                        // Next button
                        const nextButton = document.createElement('button');
                        nextButton.classList.add('page-btn');
                        nextButton.innerText = 'Next';
                        nextButton.disabled = currentPage === totalPages;
                        nextButton.onclick = () => {
                            if (currentPage < totalPages) {
                                currentPage++;
                                displayRecords(currentPage);
                                setupPagination();
                            }
                        };
                        paginationDiv.appendChild(nextButton);
                    }

                    // Initial display
                    displayRecords(currentPage);
                    setupPagination();
                } else {
                    Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                }
            }
        });
    });

        
        
    </script>
</body>
</html>
