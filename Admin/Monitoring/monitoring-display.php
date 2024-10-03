<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");
require("../../includes/authentication.php");

// Action after logout button
if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage reference data</title>
    <link rel="stylesheet" type="text/css" href="/Styles/manage-ref-data.css">
    <link rel="stylesheet" type="text/css" href="/Styles/breadCrumbs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

    <style>
        .content {
            display: none; 
            border: 1px solid #ccc; 
            padding: 5px; 
            margin-top: 10px; 
            flex-wrap: wrap; 
            border-top:none;
        }
        .pencil-box {
            width: 200px;
            background-color: lightblue; /* Background color for the pencil */
            clip-path: polygon(0 0, 80% 0, 100% 50%, 80% 100%, 0 100%);
            border: none;
            margin: 5px; /* Optional: spacing between the pencil shapes */
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: 333;
            /* font-weight: bold; */
            text-align: center;
            margin-left:25px;
            padding-right:20px;
            font-size:11px;
            font-style:italic;
            
        }
        .row-box{
            border: 1px solid #ccc;
            border-bottom:none;
        }
        .trigger {
            cursor: pointer; 
            float: right; 
        }
        .search-pane{
            display:flex;
        }
        /* Flex box left and right */
        .flex-container {
        display: flex;
        flex-direction: row;
        
        }

        .flex-item-left {
        background-color: #f1f1f1;
        padding: 10px;
        flex: 30%;
        }

        .flex-item-right {
        background-color: #f1f1f1;
        padding: 5px;
        flex: 70%;
        }

        @media (max-width: 800px) {
        .flex-container {
            flex-direction: column;
        }
        }

        /* Chart style */
        .chart-container {
            
            height: 300px; /* Set the height for all charts */
        }
    </style>

    <script>
        $(document).ready(function() {
            $(".trigger").click(function() {
                // If content is hidden
                if ($(".content").is(":hidden")) {
                    $(".content").css("display", "flex").hide().slideToggle(100); 
                    
                } else {
                    $(".content").slideToggle(300, function() {
                        $(this).css("display", "none");
                    });
                }
            });
        });
    </script>
</head>
<body>
<?php 
include("../../templates/nav-bar.php");
?>

<div class="container">
    <!-- a simple div with some links -->
    <?php if ($_SESSION['mode'] == 'light'): ?>
        <div class="breadcrumb flat">
            <a href="#">Requests</a>
            <a href="#" class="active">Request list</a>
        </div>
    <?php else: ?>
        <div class="breadcrumb">
            <a href="#">Requests</a>
           
            <a href="#" class="active">Request list</a>
        </div>
    <?php endif; ?>

    <!-- display container -->
    <div class="search-pane">
        <i class="fas fa-filter" ></i>

        <button class="btn btn-primary"  >Refresh</button>
    </div>

    <div class="flex-container">
        <div class="flex-item-left">
            <!-- bar chart -->
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-body chart-container">
                        <div style="display:flex">
                            <label for="yearForBarChart" style="margin-right:10px">Select Year:</label>
                            <select id="year"></select>
                        </div>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- line chart -->
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-body chart-container">
                        <div style="display:flex">
                            <label for="yearForLineChart" style="margin-right:10px">Select Year:</label>
                            <select id="yearForLineChart"></select>
                        </div>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division of flex Left and Right -->

        <div class="flex-item-right">
            <div class="row-box">
                <span class="trigger">▼</span> <!-- Arrow down icon -->
                Click to toggle content
            </div>
            <div class="content">
                <div class="pencil-box">
                    <div style="display:flex;padding:6px">
                        This is a sample text from process. And no other text from another message
                    </div>
                </div> 
            </div>

            <div class="row-box">
                <span class="trigger">▼</span> <!-- Arrow down icon -->
                Click to toggle content
            </div>
            <div class="content">
                <div class="pencil-box">
                    <div style="display:flex;padding:6px">
                        This is a sample text from process. And no other text from another message
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getDate();
    });
    function getDate(){
        var today = new Date();

        var day = today.getDate();  // Get the day of the month (1-31)
        var month = today.getMonth() + 1;  // Get the month (0-11, so we add 1)
        var year = today.getFullYear();  // Get the full year (e.g., 2024)

        // Format the date as Month/Day/Year
        var formattedDate = month + '/' + day + '/' + year;

        console.log(formattedDate);  // Output: "9/16/2024" (example for September 16, 2024)

    }
    // Get the current year
    const currentYear = new Date().getFullYear();

    // Get the year select elements for both charts
    const yearSelectForBarChart = document.getElementById('year');
    const yearSelectForLineChart = document.getElementById('yearForLineChart');

    // Function to populate the year options
    function populateYearSelect(selectElement) {
        for (let year = currentYear; year >= 2024; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            selectElement.appendChild(option);
        }
    }

    // Populate both select elements
    populateYearSelect(yearSelectForBarChart);
    populateYearSelect(yearSelectForLineChart);

    // Optional: Handle year selection for the line chart
    yearSelectForLineChart.addEventListener('change', (event) => {
        console.log(`Selected year for Line Chart: ${event.target.value}`);
    });

    // Optional: Handle year selection for the bar chart
    yearSelectForBarChart.addEventListener('change', (event) => {
        console.log(`Selected year for Bar Chart: ${event.target.value}`);
    });


    var ctxBar = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Monthly Donations',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    // line chart 
    var ctxLine = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','Aug','Sep','Oct','Nov','Dec'],
            datasets: [
                {
                    label: 'Pending',
                    data: [65, 59, 80, 81, 56, 55, 40,35,73,23,46,83],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Cancelled',
                    data: [28, 48, 40, 19, 86, 27, 90,41,27,83,35,57],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Completed',
                    data: [18, 48, 77, 9, 100, 27, 40,62,46,18,94,34],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Cases Over Time',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php 
include("../../templates/nav-bar2.php");
?>
</body>
</html>