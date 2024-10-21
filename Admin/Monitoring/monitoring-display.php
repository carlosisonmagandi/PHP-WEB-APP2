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
            background-color: #002f6c; /* Background color for the pencil */
            clip-path: polygon(0 0, 80% 0, 100% 50%, 80% 100%, 0 100%);
            border: none;
            margin: 5px; /* Optional: spacing between the pencil shapes */
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f1f1f1;
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
            font-family:'Poppins',sans-serif;
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
                // Toggle the content only for the clicked trigger
                var content = $(this).closest('.row-box').next(".content");
                
                if (content.is(":hidden")) {
                    content.css("display", "flex").hide().slideToggle(100);
                } else {
                    content.slideToggle(300, function() {
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
        

        <!-- Division of flex Left and Right -->

        <div class="flex-item-right">
            <div class="row-box">
                <span class="trigger">▼</span> <!-- Arrow down icon -->
                <b>RE000000123</b>
            </div>
            <div class="content">
                <div class="pencil-box">
                    <div style="display:flex;padding:6px">
                        Request logged
                    </div>
                </div> 
                <div class="pencil-box">
                    <div style="display:flex;padding:6px">
                        Approved by Admin John Doe
                    </div>
                </div>
                <div class="pencil-box">
                    <div style="display:flex;padding:6px">
                        Admin requested for additional certification from requestee
                    </div>
                </div>
                <div class="pencil-box">
                    <div style="display:flex;padding:6px">
                        Staff attached the additional requirement
                    </div>
                </div>
                <div class="pencil-box">
                    <div style="display:flex;padding:6px">
                        Request was set to complete status by Admin John Doe
                    </div>
                </div>
            </div>

            <div class="row-box">
                <span class="trigger">▼</span> <!-- Arrow down icon -->
                <b>RE000000124</b>
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

<?php 
include("../../templates/nav-bar2.php");
?>
</body>
</html>