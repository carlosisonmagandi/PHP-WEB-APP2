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
</head>
<body>

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
                        let record = data.data;
                        console.log(record);
                        // Populate form fields with the fetched data
                        // $('#sitio').val(record.sitio);
                        
                    } else {
                        Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                }
            });
        });
        
        const recordsPerPage = 15; // Number of records to display per page
        let currentPage = 1; // Current page number

        // Sample data
        const records = [
            { id: 125, name: 'Joseph Abraham, Jessica Gojo', date: '2024-10-26', officer: 'CENRO', qty: 2412, volume: '160 bd', linear: 130, estValue: '103,820.00', species: 'Acacia', depository: 'Lalakay, Los Banos Laguna', apprehension: 'Sitio Makulot Halang, Calamba Laguna', vehicle: 'Toyota', vehicleType: 'Closed Van', plate: 'WLM-775', conveyanceValue: 'Php. 200,000.00', status: 'Final Report submitted to R.O dated 06/25/2020', remarks: 'Sample record' },
            { id: 126, name: 'Maria Smith', date: '2024-10-27', officer: 'CENRO', qty: 1500, volume: '120 bd', linear: 100, estValue: '90,000.00', species: 'Mahogany', depository: 'Malolos, Bulacan', apprehension: 'San Miguel, Bulacan', vehicle: 'Mitsubishi', vehicleType: 'Pick-up', plate: 'ABC-123', conveyanceValue: 'Php. 150,000.00', status: 'Pending Report', remarks: 'Sample record 2' },
            { id: 127, name: 'John Doe', date: '2024-10-28', officer: 'CENRO', qty: 3000, volume: '200 bd', linear: 150, estValue: '150,000.00', species: 'Teak', depository: 'Calamba, Laguna', apprehension: 'Calamba, Laguna', vehicle: 'Ford', vehicleType: 'Van', plate: 'XYZ-456', conveyanceValue: 'Php. 300,000.00', status: 'Final Report submitted to R.O dated 07/30/2020', remarks: 'Sample record 3' },
            { id: 128, name: 'Jane Roe', date: '2024-10-29', officer: 'CENRO', qty: 500, volume: '60 bd', linear: 80, estValue: '40,000.00', species: 'Pine', depository: 'Taguig, Metro Manila', apprehension: 'Pasig, Metro Manila', vehicle: 'Nissan', vehicleType: 'SUV', plate: 'GHI-789', conveyanceValue: 'Php. 50,000.00', status: 'Pending Review', remarks: 'Sample record 4' },
            { id: 129, name: 'Peter Parker', date: '2024-10-30', officer: 'CENRO', qty: 1000, volume: '70 bd', linear: 90, estValue: '60,000.00', species: 'Oak', depository: 'Quezon City', apprehension: 'Makati City', vehicle: 'Honda', vehicleType: 'Coupe', plate: 'JKL-012', conveyanceValue: 'Php. 80,000.00', status: 'Closed', remarks: 'Sample record 5' },
            { id: 130, name: 'Alice Cooper', date: '2024-11-01', officer: 'CENRO', qty: 1200, volume: '150 bd', linear: 110, estValue: '75,000.00', species: 'Mahogany', depository: 'Batangas City', apprehension: 'Nasugbu, Batangas', vehicle: 'Toyota', vehicleType: 'Pickup', plate: 'ABC-234', conveyanceValue: 'Php. 120,000.00', status: 'Pending Report', remarks: 'Sample record 6' },
            { id: 131, name: 'Mark Twain', date: '2024-11-02', officer: 'CENRO', qty: 1800, volume: '300 bd', linear: 200, estValue: '150,000.00', species: 'Teak', depository: 'Manila', apprehension: 'Quezon City', vehicle: 'Mitsubishi', vehicleType: 'L300', plate: 'XYZ-789', conveyanceValue: 'Php. 250,000.00', status: 'Final Report submitted to R.O dated 08/15/2020', remarks: 'Sample record 7' },
            { id: 132, name: 'Lucy Liu', date: '2024-11-03', officer: 'CENRO', qty: 2200, volume: '250 bd', linear: 160, estValue: '130,000.00', species: 'Pine', depository: 'Cavite', apprehension: 'Imus, Cavite', vehicle: 'Isuzu', vehicleType: 'Closed Van', plate: 'LMN-456', conveyanceValue: 'Php. 200,000.00', status: 'Pending Review', remarks: 'Sample record 8' },
            { id: 133, name: 'Tom Hanks', date: '2024-11-04', officer: 'CENRO', qty: 1500, volume: '100 bd', linear: 90, estValue: '70,000.00', species: 'Cedar', depository: 'Laguna', apprehension: 'Santa Rosa, Laguna', vehicle: 'Honda', vehicleType: 'Sedan', plate: 'OPQ-123', conveyanceValue: 'Php. 80,000.00', status: 'Closed', remarks: 'Sample record 9' },
            { id: 134, name: 'Emma Watson', date: '2024-11-05', officer: 'CENRO', qty: 2000, volume: '300 bd', linear: 250, estValue: '180,000.00', species: 'Bamboo', depository: 'Bulacan', apprehension: 'Guiguinto, Bulacan', vehicle: 'Suzuki', vehicleType: 'Mini Truck', plate: 'RST-234', conveyanceValue: 'Php. 150,000.00', status: 'Final Report submitted to R.O dated 09/10/2020', remarks: 'Sample record 10' },
            { id: 135, name: 'Robert Pattinson', date: '2024-11-06', officer: 'CENRO', qty: 1500, volume: '250 bd', linear: 200, estValue: '135,000.00', species: 'Mahogany', depository: 'Laguna', apprehension: 'San Pedro, Laguna', vehicle: 'Toyota', vehicleType: 'SUV', plate: 'ABC-123', conveyanceValue: 'Php. 100,000.00', status: 'Final Report submitted to R.O dated 09/11/2020', remarks: 'Sample record 11' },
            { id: 136, name: 'Scarlett Johansson', date: '2024-11-07', officer: 'CENRO', qty: 2500, volume: '500 bd', linear: 300, estValue: '250,000.00', species: 'Teak', depository: 'Cavite', apprehension: 'Imus, Cavite', vehicle: 'Mitsubishi', vehicleType: 'Pickup', plate: 'DEF-456', conveyanceValue: 'Php. 120,000.00', status: 'Final Report submitted to R.O dated 09/12/2020', remarks: 'Sample record 12' },
            { id: 137, name: 'Chris Hemsworth', date: '2024-11-08', officer: 'CENRO', qty: 1800, volume: '400 bd', linear: 280, estValue: '200,000.00', species: 'Mahogany', depository: 'Rizal', apprehension: 'Antipolo, Rizal', vehicle: 'Honda', vehicleType: 'Sedan', plate: 'GHI-789', conveyanceValue: 'Php. 110,000.00', status: 'Final Report submitted to R.O dated 09/13/2020', remarks: 'Sample record 13' },
            { id: 138, name: 'Natalie Portman', date: '2024-11-09', officer: 'CENRO', qty: 1600, volume: '350 bd', linear: 260, estValue: '190,000.00', species: 'Cedar', depository: 'Batangas', apprehension: 'Lipa, Batangas', vehicle: 'Nissan', vehicleType: 'Van', plate: 'JKL-012', conveyanceValue: 'Php. 115,000.00', status: 'Final Report submitted to R.O dated 09/14/2020', remarks: 'Sample record 14' },
            { id: 139, name: 'Tom Hiddleston', date: '2024-11-10', officer: 'CENRO', qty: 1700, volume: '450 bd', linear: 270, estValue: '205,000.00', species: 'Pine', depository: 'Quezon', apprehension: 'Tayabas, Quezon', vehicle: 'Isuzu', vehicleType: 'Truck', plate: 'MNO-345', conveyanceValue: 'Php. 125,000.00', status: 'Final Report submitted to R.O dated 09/15/2020', remarks: 'Sample record 15' },
            { id: 140, name: 'Anne Hathaway', date: '2024-11-11', officer: 'CENRO', qty: 1400, volume: '300 bd', linear: 240, estValue: '150,000.00', species: 'Bamboo', depository: 'Pampanga', apprehension: 'Angeles, Pampanga', vehicle: 'Kia', vehicleType: 'Sedan', plate: 'PQR-678', conveyanceValue: 'Php. 130,000.00', status: 'Final Report submitted to R.O dated 09/16/2020', remarks: 'Sample record 16' },
            { id: 141, name: 'Daniel Craig', date: '2024-11-12', officer: 'CENRO', qty: 1300, volume: '200 bd', linear: 230, estValue: '125,000.00', species: 'Mahogany', depository: 'Bataan', apprehension: 'Balanga, Bataan', vehicle: 'Ford', vehicleType: 'SUV', plate: 'STU-901', conveyanceValue: 'Php. 140,000.00', status: 'Final Report submitted to R.O dated 09/17/2020', remarks: 'Sample record 17' },
            { id: 142, name: 'Margot Robbie', date: '2024-11-13', officer: 'CENRO', qty: 1200, volume: '150 bd', linear: 220, estValue: '115,000.00', species: 'Teak', depository: 'Cavite', apprehension: 'Tagaytay, Cavite', vehicle: 'Hyundai', vehicleType: 'Hatchback', plate: 'VWX-234', conveyanceValue: 'Php. 150,000.00', status: 'Final Report submitted to R.O dated 09/18/2020', remarks: 'Sample record 18' },
            { id: 143, name: 'Hugh Jackman', date: '2024-11-14', officer: 'CENRO', qty: 900, volume: '100 bd', linear: 210, estValue: '100,000.00', species: 'Cedar', depository: 'Laguna', apprehension: 'Biñan, Laguna', vehicle: 'Subaru', vehicleType: 'Compact', plate: 'YZA-567', conveyanceValue: 'Php. 160,000.00', status: 'Final Report submitted to R.O dated 09/19/2020', remarks: 'Sample record 19' },
            { id: 144, name: 'Ryan Reynolds', date: '2024-11-15', officer: 'CENRO', qty: 1100, volume: '125 bd', linear: 240, estValue: '125,000.00', species: 'Pine', depository: 'Batangas', apprehension: 'Tanauan, Batangas', vehicle: 'Chevrolet', vehicleType: 'SUV', plate: 'BCD-678', conveyanceValue: 'Php. 170,000.00', status: 'Final Report submitted to R.O dated 09/20/2020', remarks: 'Sample record 20' },
            { id: 145, name: 'Emma Stone', date: '2024-11-16', officer: 'CENRO', qty: 950, volume: '175 bd', linear: 195, estValue: '110,000.00', species: 'Bamboo', depository: 'Bulacan', apprehension: 'San Ildefonso, Bulacan', vehicle: 'Suzuki', vehicleType: 'Mini Truck', plate: 'EFG-345', conveyanceValue: 'Php. 180,000.00', status: 'Final Report submitted to R.O dated 09/21/2020', remarks: 'Sample record 21' },
            { id: 146, name: 'Chris Evans', date: '2024-11-17', officer: 'CENRO', qty: 800, volume: '90 bd', linear: 190, estValue: '95,000.00', species: 'Mahogany', depository: 'Rizal', apprehension: 'Rodriguez, Rizal', vehicle: 'Nissan', vehicleType: 'Pickup', plate: 'HIJ-234', conveyanceValue: 'Php. 160,000.00', status: 'Final Report submitted to R.O dated 09/22/2020', remarks: 'Sample record 22' },
            { id: 147, name: 'Gal Gadot', date: '2024-11-18', officer: 'CENRO', qty: 700, volume: '80 bd', linear: 185, estValue: '85,000.00', species: 'Cedar', depository: 'Quezon', apprehension: 'Lucena, Quezon', vehicle: 'Ford', vehicleType: 'Van', plate: 'KLM-567', conveyanceValue: 'Php. 140,000.00', status: 'Final Report submitted to R.O dated 09/23/2020', remarks: 'Sample record 23' },
            { id: 148, name: 'Zoe Saldana', date: '2024-11-19', officer: 'CENRO', qty: 600, volume: '70 bd', linear: 175, estValue: '75,000.00', species: 'Teak', depository: 'Pampanga', apprehension: 'Mabalacat, Pampanga', vehicle: 'Kia', vehicleType: 'Sedan', plate: 'NOP-890', conveyanceValue: 'Php. 155,000.00', status: 'Final Report submitted to R.O dated 09/24/2020', remarks: 'Sample record 24' },
            { id: 149, name: 'Jason Momoa', date: '2024-11-20', officer: 'CENRO', qty: 850, volume: '95 bd', linear: 195, estValue: '90,000.00', species: 'Bamboo', depository: 'Bataan', apprehension: 'Orani, Bataan', vehicle: 'Chevrolet', vehicleType: 'Pickup', plate: 'QRS-123', conveyanceValue: 'Php. 165,000.00', status: 'Final Report submitted to R.O dated 09/25/2020', remarks: 'Sample record 25' },
            { id: 150, name: 'Dwayne Johnson', date: '2024-11-21', officer: 'CENRO', qty: 950, volume: '100 bd', linear: 210, estValue: '100,000.00', species: 'Pine', depository: 'Laguna', apprehension: 'Santa Rosa, Laguna', vehicle: 'Subaru', vehicleType: 'SUV', plate: 'TUV-456', conveyanceValue: 'Php. 175,000.00', status: 'Final Report submitted to R.O dated 09/26/2020', remarks: 'Sample record 26' }
        ];

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
                        <td>${record.title}</td>
                        <td>${record.depository_sitio}&nbsp ${record.depository_barangay}&nbsp , ${record.depository_city} &nbsp ${record.depository_province} </td>
                        <td>${record.sitio}&nbsp ${record.barangay}&nbsp , ${record.city_municipality} &nbsp ${record.province} </td>
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

        // Function to setup pagination
        function setupPagination() {
            const totalPages = Math.ceil(records.length / recordsPerPage);
            const paginationDiv = document.getElementById('pagination');
            paginationDiv.innerHTML = ''; // Clear previous pagination

            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.classList.add('page-btn');
                pageButton.innerText = i;
                pageButton.onclick = () => {
                    currentPage = i;
                    displayRecords(currentPage);
                };
                paginationDiv.appendChild(pageButton);
            }
        }

        // Initial display
        displayRecords(currentPage);
        setupPagination();
    </script>
</body>
</html>
