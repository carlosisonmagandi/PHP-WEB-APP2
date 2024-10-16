<?php
session_start();
require("../../includes/session.php");
require("../../includes/darkmode.php");
require("../../includes/authentication.php");

if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: ../../index.php");
    exit;
};
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../../Styles/styles.css">
    <link rel="stylesheet" type="text/css" href="../../Styles/darkmode.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- data table -->
    <script src="/Styles/data-table/jquery-3.7.1.js"></script>
    <script src="/Styles/data-table/dataTables.js"></script>
    <link href="/Styles/data-table/dataTables.css" rel="stylesheet" />

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .chart-container {
            position: relative;
            height: 400px; /* Set the height for all charts */
        }
    </style>
</head>
<body>
<?php include ("../../templates/nav-bar.php");?>

<div class="container-fluid mt-5">
    <div class="row ">
        <!-- <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body" id="confiscatedRecord">Confiscated Record:</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" id='viewRecordDetailsButton'>View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body" id="donatedRecord">Donated forest product/s</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" id="viewDonationDetailsButton">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body" id="allUser">Active User</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" id="viewUserDetailsButton">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Forest Product's EMV (Php)</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" id="viewEmvDetailsButton">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-body chart-container">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-body chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-body chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<?php 
include  "../../templates/nav-bar2.php"; 
?>
<script>
    $(document).ready(function() {
        getDate();
        
        //Get total records of confiscated items(logs,conveyance and equipments)
        $.ajax({
            url: '/Dashboard/ConfiscatedRecord/get-confiscated.php',
            dataType: 'json',
            success: function(data) { 
                $('#confiscatedRecord').html('Confiscated Record: <span style="float: right;"><b>' + data[0].total_count + '</b></span>');

            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get inventory
        $.ajax({
            url: '/Dashboard/ConfiscatedRecord/get-inventory.php',
            dataType: 'json',
            success: function(data) {
            inventoryData = '<span><b>' + data[0].inventory_count + '</b></span>';

            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get conveyance
        $.ajax({
            url: '/Dashboard/ConfiscatedRecord/get-conveyance.php',
            dataType: 'json',
            success: function(data) {
            conveyanceData = '<span><b>' + data[0].conveyance_count + '</b></span>';

            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get equipments
        $.ajax({
            url: '/Dashboard/ConfiscatedRecord/get-equipments.php',
            dataType: 'json',
            success: function(data) {
            equipmentData = '<span><b>' + data[0].equipment_count + '</b></span>';

            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get completed Donations
        $.ajax({
            url: '/Dashboard/DonatedForestProduct/get-completed-donations.php',
            dataType: 'json',
            success: function(data) {
                // console.log( data.total_quantity);
            completedDonationData = '<span><b>' + data.total_quantity + '</b></span>';

            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get total count of user
        $.ajax({
            url: '/Dashboard/ActiveUser/get-total-users.php',
            dataType: 'json',
            success: function(data) { 
                $('#allUser').html('Active Users: <span style="float: right;"><b>' + data[0].total_count_users + '</b></span>');

            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get details view of User 
        $.ajax({
            url: '/Dashboard/ActiveUser/get-role.php',
            dataType: 'json',
            success: function(data) {
            //  console.log( data[0].role_admin);
            userDataAdmin = '<span><b>' + data[0].role_admin + '</b></span>';
            userDataStaff = '<span><b>' + data[0].role_staff + '</b></span>';
            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get EMV view of User 
        $.ajax({
            url: '/Dashboard/EstimatedValue/get-emv.php',
            dataType: 'json',
            success: function(data) {
            //  console.log( data[0].role_admin);
            emvData = '<span><b>' + data[0].total_emv + '</b></span>';
           
            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });
    });

    //Confiscated Record View details
    const buttonViewRecordDetails = document.getElementById('viewRecordDetailsButton');
    buttonViewRecordDetails.addEventListener('click', viewRecordDetails);
    function viewRecordDetails(){
        Swal.fire({
            title: 'Summary',
            html:`
                <style>
                    .parent {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        grid-template-rows: repeat(3, 1fr);
                        gap: 1px;
                    }
                        
                    .div1{
                        border-bottom:1px solid gray;   
                        padding-top: 6px;
                        padding-bottom:6px;
                    }
                    .div2 {
                        grid-column-start: 1;
                        grid-row-start: 2;
                        border-bottom:1px solid gray;  
                        padding-top: 6px;
                        padding-bottom:6px; 
                    }

                    .div3 {
                        grid-column-start: 1;
                        grid-row-start: 3;
                        border-bottom:1px solid gray; 
                        padding-top: 6px;
                        padding-bottom:6px;  
                    }

                    .div4 {
                        grid-column-start: 2;
                        grid-row-start: 1;
                        border-bottom:1px solid gray;  
                        padding-top: 6px;
                        padding-bottom:6px; 
                    }

                    .div5 {
                        grid-column-start: 2;
                        grid-row-start: 2;
                        border-bottom:1px solid gray; 
                        padding-top: 6px;
                        padding-bottom:6px;  
                    }
                    .div6{
                        border-bottom:1px solid gray; 
                        padding-top: 6px;
                        padding-bottom:6px;  
                    }    
                </style>
                
                <div class="parent">
                    <div class="div1">Forest products:</div>
                    <div class="div2">Conveyance:</div>
                    <div class="div3">Machineries:</div>
                    <div class="div4">${inventoryData}</div>
                    <div class="div5">${conveyanceData}</div>
                    <div class="div6">${equipmentData}</div>
                </div>                      `
        });
    }

    //Donation view details
    const buttonViewDonationDetails = document.getElementById('viewDonationDetailsButton');
    buttonViewDonationDetails.addEventListener('click', viewDonationDetails);

    function viewDonationDetails(){
        Swal.fire({
            title: 'Summary',
            html:`
                <style>
                    .parent {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        grid-template-rows: repeat(1, 1fr);
                        gap: 2px;
                    }
                    .div1,.div2{
                        border-bottom:1px solid gray;   
                        padding-top: 6px;
                        padding-bottom:6px;
                    }       
                </style>
                    <br>
                    <div class="parent">
                        <div class="div1">Completed Donations (Qty):</div>
                        <div class="div2">${completedDonationData}</div>
                    </div>
                    <br>                      
            `
        });
    }

    //Active user view details
    const buttonViewUserDetails = document.getElementById('viewUserDetailsButton');
    buttonViewUserDetails.addEventListener('click', viewUserDetails);

    function viewUserDetails(){
        Swal.fire({
            title: 'Role Summary',
            html:`
                <style>                    
                    .parent {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        grid-template-rows: repeat(2, 1fr);
                        gap: 2px;
                    }
                        
                    .div1{
                        border-bottom:1px solid gray;   
                        padding-top: 6px;
                        padding-bottom:6px;
                    }
                    .div2 {
                        grid-column-start: 1;
                        grid-row-start: 2;
                        border-bottom:1px solid gray;   
                        padding-top: 6px;
                        padding-bottom:6px;
                    }

                    .div3 {
                        grid-column-start: 2;
                        grid-row-start: 1;
                        border-bottom:1px solid gray;   
                        padding-top: 6px;
                        padding-bottom:6px;
                    }       
                    .div4{
                        border-bottom:1px solid gray;   
                        padding-top: 6px;
                        padding-bottom:6px;
                    }
                </style>
                    <br>                  
                    <div class="parent">
                        <div class="div1">Admin:</div>
                        <div class="div2">Staff:</div>
                        <div class="div3">${userDataAdmin}</div>
                        <div class="div4">${userDataStaff}</div>
                    </div> 
                    <br>                      
            `
        });
    }

    //EMV view details
    const buttonViewEMVDetails = document.getElementById('viewEmvDetailsButton');
    buttonViewEMVDetails.addEventListener('click', viewEMVDetails);

    function viewEMVDetails(){
        Swal.fire({
            title: 'Role Summary',
            html:`
                <style>                      
                    .parent {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        grid-template-rows: repeat(1, 1fr);
                        gap: 2px;
                    }     
                </style>
                    <br>                  
                    <div class="parent">
                        <div class="div1">Forest product estimated value:</div>
                        <div class="div2">Php. ${emvData}</div>
                    </div>
                    <br>                      
            `
        });
    }

    function getDate(){
        var today = new Date();

        var day = today.getDate();  
        var month = today.getMonth() + 1;  
        var year = today.getFullYear();  

        // Format the date as Month/Day/Year
        var formattedDate = month + '/' + day + '/' + year;

        console.log(formattedDate);  // Output: "9/16/2024" (example for September 16, 2024)

    }
    
    // Function to fetch chart data
    function fetchChartData() {
        $.ajax({
            url: '/Dashboard/LineGraph/get-all.php', // Replace with the path to your PHP script
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                updateChart(data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    const colorOptions = [
        'rgba(54, 162, 235, 0.2)',  // Blue
        'rgba(255, 206, 86, 0.2)',   // Yellow
        'rgba(75, 192, 192, 0.2)',   // Teal
        'rgba(255, 99, 132, 0.2)',    // Red
        'rgba(255, 159, 64, 0.2)',   // Orange
        'rgba(153, 102, 255, 0.2)',  // Purple
        'rgba(220, 50, 41, 0.2)',    // Darker Tomato
        'rgba(0, 153, 204, 0.2)',    // Darker Cyan
        'rgba(150, 150, 150, 0.2)',  // Darker Grey
        'rgba(0, 204, 0, 0.2)',      // Darker Green
        'rgba(204, 0, 119, 0.2)',    // Darker Deep Pink
        'rgba(102, 204, 0, 0.2)',    // Darker Chartreuse
        'rgba(102, 0, 102, 0.2)',     // Darker Purple
        'rgba(204, 130, 0, 0.2)',    // Darker Orange
        'rgba(51, 0, 102, 0.2)',     // Darker Indigo
        'rgba(0, 102, 102, 0.2)',    // Darker Teal
        'rgba(102, 153, 204, 0.2)',  // Darker Sky Blue
        'rgba(204, 204, 178, 0.2)',  // Darker Bisque
        'rgba(178, 51, 204, 0.2)',   // Darker Lavender
        'rgba(204, 0, 204, 0.2)'     // Darker Magenta  
    ];

    // Function to get a random color from the options
    function getRandomColor() {
        const randomIndex = Math.floor(Math.random() * colorOptions.length);
        return colorOptions[randomIndex];
    }
    // Function to update the chart with fetched data
    function updateChart(data) {
        var ctxLine = document.getElementById('lineChart').getContext('2d');

        if (window.lineChart && typeof window.lineChart.destroy === 'function') {
            window.lineChart.destroy();
        }

        var datasets = [];
        var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

        // Loop through the data to create datasets
        data.forEach(function(item) {
            const backgroundColor = getRandomColor(); 
            const borderColor = backgroundColor.replace(/0\.\d+/, '1'); // Makes the color fully opaque

            datasets.push({
                label: item.label,
                data: item.data,
                backgroundColor: backgroundColor, 
                borderColor: borderColor, 
                borderWidth: 1
            });
        });

        // Create a new chart instance
        window.lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Confiscated Over Time',
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
    }

    // Function to generate a random color with a transparency level
    function getRandomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgba(${r}, ${g}, ${b}, 0.2)`; 
    }

    $(document).ready(function() {
        fetchChartData();
    });


    //Pie chart
    $(document).ready(function() {
        fetchPieChartData();
    });

    function fetchPieChartData() {
        $.ajax({
            url: '/Dashboard/PieGraph/get-all.php', // Replace with the correct path to your PHP script
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                updatePieChart(data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function updatePieChart(data) {
        // Prepare labels and data arrays for the chart
        const labels = data.map(item => item.city_municipality);
        const counts = data.map(item => item.apprehension_count);

        // Array of colors to choose from
        const colors = [
            'rgba(54, 162, 235, 0.2)',    // Light Blue
            'rgba(255, 206, 86, 0.2)',     // Light Yellow
            'rgba(75, 192, 192, 0.2)',     // Light Cyan
            'rgba(255, 99, 132, 0.2)',     // Light Red
            'rgba(153, 102, 255, 0.2)',    // Light Purple
            'rgba(255, 159, 64, 0.2)',     // Light Orange
            'rgba(220, 50, 41, 0.2)',      // Darker Tomato
            'rgba(0, 153, 204, 0.2)',      // Darker Cyan
            'rgba(150, 150, 150, 0.2)',    // Darker Grey
            'rgba(0, 204, 0, 0.2)',        // Darker Green
            'rgba(204, 0, 119, 0.2)',      // Darker Deep Pink
            'rgba(102, 204, 0, 0.2)',      // Darker Chartreuse
            'rgba(102, 0, 102, 0.2)',      // Darker Purple
            'rgba(204, 130, 0, 0.2)',      // Darker Orange
            'rgba(51, 0, 102, 0.2)',       // Darker Indigo
            'rgba(0, 102, 102, 0.2)',      // Darker Teal
            'rgba(102, 153, 204, 0.2)',    // Darker Sky Blue
            'rgba(204, 204, 178, 0.2)',    // Darker Bisque
            'rgba(178, 51, 204, 0.2)',     // Darker Lavender
            'rgba(204, 0, 204, 0.2)'       // Darker Magenta
        ];

        // Generate random colors for each segment
        const backgroundColors = counts.map(() => {
            const randomIndex = Math.floor(Math.random() * colors.length);
            return colors[randomIndex];
        });

        // If you have already created a pie chart, destroy it to recreate
        if (window.pieChart && typeof window.pieChart.destroy === 'function') {
            window.pieChart.destroy();
        }

        var ctxPie = document.getElementById('pieChart').getContext('2d');
        window.pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Activity Distribution',
                    data: counts,
                    backgroundColor: backgroundColors, // Use the generated random colors
                    borderColor: backgroundColors.map(color => color.replace('0.2', '1')), // Change the alpha for the border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Illegal Activities',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        });
    }




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
</script>
</body>
</html>
