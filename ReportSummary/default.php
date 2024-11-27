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
        margin-left: 3%;
        margin-right: 3%;
    }

    .form-container {
        display: flex;
        align-items: center; /* Align elements vertically */
        gap: 20px; /* Gap between elements */
        width: 100%; /* Ensure the container takes the full width */
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
        margin-top:3%;
        margin-right:3%;
        margin-left:3%;
        border: 1px solid gray;
        padding:10px;
    }
    .area-container{
        display: flex;
        align-items: center; /* Align elements vertically */
        gap: 20px; /* Gap between elements */
        margin-top:10px;
    }
    </style>
</head>
<body>
    
<?php 
    include("../templates/nav-bar.php");
    ?>
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
    <br>
    <center><p>List of Apprehended Forest Products, Equipments and Conveyances of PENRO Laguna</p></center>
    <div class="tableDiv">
        <!-- <b><p>Select date range</p></b> -->
        <form>
            <div class="form-container">
                <div>
                    <label for="start-date">Start Date:</label>
                    <input type="month" id="start-date" name="start-date">
                </div>
                <div>
                    <label for="end-date">End Date:</label>
                    <input type="month" id="end-date" name="end-date">
                </div>
                <div>
                    
                </div>
            </div>
        </form>
    </div>
    <button class="btn btn-primary" id="buttonPrint" onclick="window.print()">
        <i class="fas fa-print"></i>&nbsp Print
    </button>
    <br>

    <div class="total-number-per-place">
        <b> Total number of illegal activity per Area </b>
        <div class="area-container">
            <div>Calamba: 3</div>
            <div>Sta Cruz: 10</div>
        </div>
    </div>

    <script>
        function formatDate(date) {
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add leading zero if month is single-digit
            return `${year}-${month}`;
        }

        function logDates() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            if (startDate && endDate) {
                const start = new Date(startDate + "-01");
                const end = new Date(endDate + "-01");

                // Check if the end date is before the start date
                if (end < start) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Date Range',
                        text: 'The end date cannot be before the start date.',
                        confirmButtonText: 'OK'
                    });
                    return; // Prevent further execution if the dates are invalid
                }

                const monthsBetween = getMonthsInRange(start, end);

                monthsBetween.forEach(month => {
                    console.log(month);
                });
            }
        }

        function getMonthsInRange(start, end) {
            const months = [];
            let currentDate = new Date(start);

            while (currentDate <= end) {
                months.push(formatDate(currentDate)); // Format as YYYY-MM
                currentDate.setMonth(currentDate.getMonth() + 1);
            }

            return months;
        }
        

        // Event listeners for the input fields
        document.getElementById('start-date').addEventListener('change', logDates);
        document.getElementById('end-date').addEventListener('change', logDates);
    
    </script>

    <!-- ---------------------------------------------- -->
    
    <?php 
    include("../templates/nav-bar2.php");
    ?>
</body>
</html>
