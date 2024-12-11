<?php
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");

if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}

// Get the current year and current month
$currentYear = date('Y');
$currentMonth = date('m');
$startDate = $currentYear . "-01"; // Start date is always January of the current year
$endDate = $currentYear . "-" . $currentMonth; // End date is the current month
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All list</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="/Styles/sb-admin/sb-admin-styles.css" rel="stylesheet" />
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../../Styles/darkmode.css">
    <link rel="stylesheet" type="text/css" href="../../../Styles/nav-bar.css">
    <!--  To switch dark mode on or off for notification -->
    <?php 
        if(isset($_SESSION['mode'])){
            if ($_SESSION['mode'] == 'dark') {
                echo '<link rel="stylesheet" type="text/css" href="../../../Styles/notification-dark.css">';
            } else {
                echo '<link rel="stylesheet" type="text/css" href="../../../Styles/notification.css">';
            }
        }else{
            echo '<link rel="stylesheet" type="text/css" href="../../../Styles/notification.css">';
        }
    ?>  
    <style>
        .tableDiv {
            font-family: 'Poppins', sans-serif;        
            font-size: 12px;
            padding: 10px;
            border: 1px solid gray;
            margin-left: 2%;
            margin-right: 2%;
        }

        .form-container {
            display: flex;
            align-items: center; 
            gap: 20px; 
            /* width: 100%;  */
        }

        .form-container label {
            margin-right: 10px; 
        }

        .form-container div {
            display: flex;
            align-items: center;
        }

        button {
            font-size: 12px;
            cursor: pointer;
            color: #333;
        }

        #buttonPrint {
            font-size: 12px;
            cursor: pointer;
            color: #f1f1f1;
            float:right;
            margin-top:10px;
            margin-right:3%;
        }

        .total-number-per-place{
            margin-top:2%;
            margin-right:2%;
            margin-left:2%;
            border: 1px solid gray;
            padding:10px;
        }

        .area-container{
            display: flex;
            align-items: center; /* Align elements vertically */
            gap: 20px; /* Gap between elements */
            margin-top: 10px;
            flex-wrap: wrap; /* This will allow the elements to wrap to the next line on smaller screens */
            justify-content: flex-start; 
        }
        /* forest product and donation DIV */
        * {
        box-sizing: border-box;
        }

        .flex-container {
        display: flex;
        flex-wrap: wrap;
        /* font-size: 30px; */
        text-align: center;
        margin-top:2%;
        margin-left:2%;
        margin-right:2%;
        border:1px solid gray;
        }

        .flex-item-left {
        /* background-color: #f1f1f1; */
        padding: 10px;
        flex: 50%;
        border-right:1px solid gray;
        }

        .flex-item-right {
        /* background-color: #f1f1f1; */
        padding: 10px;
        flex: 50%;
        }

        /* Responsive layout - makes a one column-layout instead of a two-column layout */
        @media (max-width: 800px) {
        .flex-item-right, .flex-item-left {
            flex: 100%;
        }
        }
    </style>
</head>
<body>
  
<!-- Scripts -->
<!-- Note: It will not work inside header because of the php block for templates -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- data table -->
<script src="/Styles/data-table/jquery-3.7.1.js"></script>
<script src="/Styles/data-table/dataTables.js"></script>
<link href="/Styles/data-table/dataTables.css" rel="stylesheet" />

<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Content ----------------------------------------->

<center><p>List of Apprehended Forest Products, Equipments and Conveyances of PENRO Laguna</p></center>
<div class="tableDiv">
    <!-- <b><p>Select date range</p></b> -->
    <form>
        <div class="form-container">
            <div>
                <label for="start-date">Start Date:</label>
                <!-- Set the default value to January of the current year -->
                <input type="month" id="start-date" name="start-date" value="<?php echo $startDate; ?>">
            </div>
            <div>
                <label for="end-date">End Date:</label>
                <!-- Set the default value to the current month -->
                <input type="month" id="end-date" name="end-date" value="<?php echo $endDate; ?>">
            </div>
            <div>
                
            </div>
        </div>
    </form>
</div>

<div class="total-number-per-place">
    <div class="area-container">
        <!-- Populate from database -->
    </div>
    <br>
    <i>Displays location with the highest count of illegal activities</i>
</div>

<div class="flex-container">
 <!--Conficated forest product div -->
  <div class="flex-item-left">
    <div class="container">
        <p><b>Total number of confiscated Forest products</b></p>            
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th >Type</th>
                        <th>Total counts</th>
                        <th>Total estimated value</th>
                    </tr>
                </thead>
                <tbody  id="species-summary-table">
                <!-- populate data from db -->
                </tbody>
            </table>
        </div>
    </div>
  </div>
  <!-- Donation div -->
  <div class="flex-item-right">
    <div class="container">
        <p><b>Total number of Donated Dorest products</b></p> 
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th >Type</th>
                        <th>Total counts</th>
                        <th>Total quantity</th>
                    </tr>
                </thead>
                <tbody  id="donation-summary-table">
                <!-- populate data from db -->
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>

<script>
    logDates();//display records initially
    
    function logDates() {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        if (startDate && endDate) { // Check if both dates are selected
            const start = new Date(startDate + "-01");  // Append "-01" to make a valid date
            const end = new Date(endDate + "-01");      // Same here for the end date

            // Check if the end date is before the start date
            if (end < start) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    text: 'The end date cannot be before the start date.',
                    confirmButtonText: 'OK'
                });
                return; 
            }

            const monthsBetween = getMonthsInRange(start, end);
            fetchFilteredData(monthsBetween);
        }
    }

    // Function to get all months in the selected range
    function getMonthsInRange(start, end) {
        const months = [];
        let currentDate = new Date(start);

        while (currentDate <= end) {
            months.push(formatDate(currentDate)); // Format as YYYY-MM
            currentDate.setMonth(currentDate.getMonth() + 1);
        }

        return months;
    }

    // Function to format date as YYYY-MM
    function formatDate(date) {
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        return `${year}-${month}`;
    }

    function fetchFilteredData(months) {
        const startDate = months[0]; // Get the first month
        const endDate = months[months.length - 1]; // Get the last month

        
        // console.log("Start Date:", startDate);  
        // console.log("End Date:", endDate);      

        $.ajax({
            url: '/ReportSummary/get-city-municipality.php',
            type: 'GET',
            dataType: 'json',
            data: {
                start_date: startDate, 
                end_date: endDate
            },
            success: function(response) {
                const areaContainer = document.querySelector('.area-container');
                areaContainer.innerHTML = ''; 
                if (response && response.length > 0) {
                    
                    // Sort the response array based on 'activity_count' in descending order
                    response.sort((a, b) => b.activity_count - a.activity_count);

                    // Get the highest and second-highest activity count
                    const highestCount = response[0].activity_count;
                    const secondHighestCount = response.length > 1 ? response[1].activity_count : highestCount;

                    $.each(response, function(index, item) {
                        const div = document.createElement('div');
                        div.innerHTML = `<strong class='city-name'>${item.city_municipality}</strong>: <h4>${item.activity_count}</h4>`;

                        div.style.padding = '10px';            
                        div.style.margin = '5px';
                        div.style.borderRadius = '6px';      
                        div.style.width = '105px';      
                        div.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.2)';

                        // Check and apply color based on activity count
                        if (item.activity_count === highestCount) {
                            div.style.backgroundColor = '#dc3545'; // Red for highest count
                            div.style.color = '#ffffff'; 
                        } else if (item.activity_count === secondHighestCount) {
                            div.style.backgroundColor = '#ffc107'; // Yellow for second-highest count
                            div.style.color = '#ffffff'; 
                        } else {
                            div.style.backgroundColor = '#28a745'; // Green for others
                            div.style.color = '#ffffff'; 
                        }

                        const cityName = div.querySelector('.city-name');
                        if (cityName) {
                            cityName.style.color = '#ffffff';  
                            cityName.style.fontSize = '11px';
                        }

                        areaContainer.appendChild(div);
                    });
                } else {
                    // If no data found for the selected date range
                    const noDataDiv = document.createElement('div');
                    noDataDiv.textContent = 'No data found for the selected date range.';
                    areaContainer.appendChild(noDataDiv);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });

        $.ajax({
            url: '/ReportSummary/get-species-summary.php', 
            type: 'GET',
            dataType: 'json',
            data: {
                start_date: startDate, 
                end_date: endDate
            },
            success: function(response) {
                const tableBody = $('#species-summary-table');
                tableBody.empty(); // Clear previous table data

                if (response && response.length > 0) {
                    // Sort the response array based on 'type_count' in descending order
                    response.sort((a, b) => b.type_count - a.type_count);

                    $.each(response, function(index, item) {
                        const row = `<tr>
                            <td>${item.species_type}</td>
                            <td>${item.type_count}</td>
                            <td>Php. ${item.total_value}</td>
                        </tr>`;

                        tableBody.append(row);
                    });
                } else {
                    const noDataRow = `<tr><td colspan="3">No data found for the selected date range.</td></tr>`;
                    tableBody.append(noDataRow);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });

        $.ajax({
            url: '/ReportSummary/get-donation-summary.php', 
            type: 'GET',
            dataType: 'json',
            data: {
                start_date: startDate, 
                end_date: endDate
            },
            success: function(response) {
                
                const tableBody = $('#donation-summary-table');
                tableBody.empty(); // Clear previous table data

                if (Array.isArray(response) && response.length > 0) {
                    // Sort the response array based on 'total_count' in descending order
                    response.sort((a, b) => b.total_count - a.total_count);

                    $.each(response, function(index, item) {
                        const row = `<tr>
                            <td>${item.type_of_requested_item}</td>
                            <td>${item.total_count}</td>
                            <td>${item.total_quantity}</td>
                        </tr>`;

                        tableBody.append(row);
                    });
                } else {
                    const noDataRow = `<tr><td colspan="3">No data found for the selected date range.</td></tr>`;
                    tableBody.append(noDataRow);
                }
            },

            error: function(xhr, status, error) {
                console.log(xhr.messageText);
                console.log(xhr.responseText);
                console.error('Error fetching data:', error);
            }
        });
    }

    document.getElementById('start-date').addEventListener('change', logDates);
    document.getElementById('end-date').addEventListener('change', logDates);
    
    function printPage() {
        // Get the current tables (species-summary-table and donation-summary-table)
        const speciesSummaryTable = document.getElementById('species-summary-table').innerHTML;
        const donationSummaryTable = document.getElementById('donation-summary-table').innerHTML;
        
        // Get the total illegal activity per area data
        const areaContainer = document.querySelector('.area-container');
        let areaTableContent = '<table><thead><tr><th>Area</th><th>Total Activity Count</th></tr></thead><tbody>';

        // Loop through the area container's children to create rows for the table
        const areaDivs = areaContainer.getElementsByTagName('div');
        for (let i = 0; i < areaDivs.length; i++) {
            const areaDiv = areaDivs[i];
            const cityName = areaDiv.querySelector('.city-name') ? areaDiv.querySelector('.city-name').textContent : '';
            const activityCount = areaDiv.querySelector('h4') ? areaDiv.querySelector('h4').textContent : '';

            // Add a row for each area
            areaTableContent += `
                <tr>
                    <td>${cityName}</td>
                    <td>${activityCount}</td>
                </tr>
            `;
        }

        areaTableContent += '</tbody></table>';

        // Build the HTML content to display in the print view
        const printContent = `
            <html>
            <head>
                <title>Print Report</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                        font-size: 12px;
                    }
                    h1 {
                        text-align: center;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        padding: 8px;
                        text-align: left;
                        border: 1px solid #ddd;
                    }
                    th {
                        background-color: #f4f4f4;
                    }
                </style>
            </head>
            <body>
                <h1>Apprehended Forest Products and Donations</h1>
                <p><b>From:</b> ${document.getElementById('start-date').value} <b>To:</b> ${document.getElementById('end-date').value}</p>
                <h3>Total Number of Confiscated Forest Products</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Total Counts</th>
                            <th>Total Estimated Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${speciesSummaryTable}
                    </tbody>
                </table>

                <h3>Total Number of Donated Forest Products</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Total Counts</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${donationSummaryTable}
                    </tbody>
                </table>

                <h3>Total Number of Illegal Activity Per Area</h3>
                ${areaTableContent}
            </body>
            </html>
        `;

        function printDashboard() {
            // Select the content you want to print (in this case, the content inside .container-fluid)
            var printContent = document.querySelector('.container-fluid').innerHTML;

            // Create a new "printable" iframe element
            const printIframe = document.createElement('iframe');
            printIframe.style.position = 'absolute';
            printIframe.style.width = '0px';
            printIframe.style.height = '0px';
            printIframe.style.border = 'none';

            // Append the iframe to the body of the document
            document.body.appendChild(printIframe);

            // Open the iframe document and write the content
            const iframeDoc = printIframe.contentWindow.document;
            iframeDoc.open();
            iframeDoc.write('<html><head><title>Print Dashboard</title>');
            iframeDoc.write('<style>body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }</style>'); // Optional CSS
            iframeDoc.write('</head><body>');
            iframeDoc.write(printContent);
            iframeDoc.write('</body></html>');
            iframeDoc.close();

            // Trigger the print dialog from the iframe content
            printIframe.contentWindow.focus(); 
            printIframe.contentWindow.print(); 

            // Remove the iframe after printing
            document.body.removeChild(printIframe);
        }
    }


</script>

</body>
</html>
