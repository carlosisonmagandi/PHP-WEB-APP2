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
    .detailDiv{
        background-color:#002f6c;
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
        background-color: #d1d1d1;
        border:1px solid #002f6c;
        border-radius:2px;
    }
    .button:hover{
        background-color: #002f6c;
        color:#d1d1d1;  
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
  <div class="flex-item-left" id="titleContainer" style="padding-left:10%;padding-right:10%;margin-top:2%">
        <!--title  -->
  </div>
</div>

<div class="container" style="overflow-y:scroll;height:450px;">
    <button onclick="redirectToUrl()" class='btn btn-default' style="border:1px solid #002f6c;font-size:12px; ">
            Add New
    </button>
    <div class="row">
        <div class="column">
            <div class="card">
                <div class="totalItemDiv" >pcs: 100</div>
                <div class="innerCardContainer">
                    <div class="imageDiv" >
                        <img class="img" src="/Images/kamagong.jpg" alt="image1" >
                    </div>
                    <div class="detailDiv">
                        <a>Kamagong</a>
                        <a>(1.871 cu.m)</a>
                        <p>Brgy. Lalakay, Los Banos Laguna </p>
                        <i><a>Apprehended Date:</a></i>
                        <i><a>2018-08-03</a></i>
                    </div>
                    <br>
                    <div class="buttonsDiv">
                        <input class="button" type="button" value="view location">
                        <input class="button" type="button" value="mode details">
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <div class="totalItemDiv" >pcs: 80</div>
                <div class="innerCardContainer">
                    <div class="imageDiv" >
                        <img class="img" src="/Images/acacia.jpg" alt="image1" >
                    </div>
                    <div class="detailDiv">
                        <a>Acacia</a>
                        <a>(1.871 cu.m)</a>
                        <p>Brgy. Lalakay, Los Banos Laguna </p>
                        <i><a>Apprehended Date:</a></i>
                        <i><a>2018-08-03</a></i>
                    </div>
                    <br>
                    <div class="buttonsDiv">
                        <input class="button" type="button" value="view location">
                        <input class="button" type="button" value="mode details">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="column">
            <div class="card">
                <div class="totalItemDiv" >pcs: 72</div>
                <div class="innerCardContainer">
                    <div class="imageDiv" >
                        <img class="img" src="/Images/coconut.jpg" alt="image1" >
                    </div>
                    <div class="detailDiv">
                        <a>Coconut</a>
                        <a>(1.871 cu.m)</a>
                        <p>Brgy. Lalakay, Los Banos Laguna </p>
                        <i><a>Apprehended Date:</a></i>
                        <i><a>2018-08-03</a></i>
                    </div>
                    <br>
                    <div class="buttonsDiv">
                        <input class="button" type="button" value="view location">
                        <input class="button" type="button" value="mode details">
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <div class="totalItemDiv" >pcs: 100</div>
                <div class="innerCardContainer">
                    <div class="imageDiv" >
                        <img class="img" src="/Images/mahogany.jpg" alt="image1" >
                    </div>
                    <div class="detailDiv">
                        <a>Mahogany</a>
                        <a>(1.871 cu.m)</a>
                        <p>Brgy. Lalakay, Los Banos Laguna </p>
                        <i><a>Apprehended Date:</a></i>
                        <i><a>2018-08-03</a></i>
                    </div>
                    <br>
                    <div class="buttonsDiv">
                        <input class="button" type="button" value="view location">
                        <input class="button" type="button" value="mode details">
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <div class="totalItemDiv" >pcs: 42</div>
                <div class="innerCardContainer">
                    <div class="imageDiv" >
                        <img class="img" src="/Images/mango.jpeg" alt="image1" >
                    </div>
                    <div class="detailDiv">
                        <a>Mango</a>
                        <a>(1.871 cu.m)</a>
                        <p>Brgy. Lalakay, Los Banos Laguna </p>
                        <i><a>Apprehended Date:</a></i>
                        <i><a>2018-08-03</a></i>
                    </div>
                    <br>
                    <div class="buttonsDiv">
                        <input class="button" type="button" value="view location">
                        <input class="button" type="button" value="mode details">
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <div class="totalItemDiv" >pcs: 35</div>
                <div class="innerCardContainer">
                    <div class="imageDiv" >
                        <img class="img" src="/Images/narra.jpg" alt="image1" >
                    </div>
                    <div class="detailDiv">
                        <a>Narra</a>
                        <a>(1.871 cu.m)</a>
                        <p>Brgy. Lalakay, Los Banos Laguna </p>
                        <i><a>Apprehended Date:</a></i>
                        <i><a>2018-08-03</a></i>
                    </div>
                    <br>
                    <div class="buttonsDiv">
                        <input class="button" type="button" value="view location">
                        <input class="button" type="button" value="mode details">
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="card">
                <div class="totalItemDiv" >pcs: 89</div>
                <div class="innerCardContainer">
                    <div class="imageDiv" >
                        <img class="img" src="/Images/yakal.jpg" alt="image1" >
                    </div>
                    <div class="detailDiv">
                        <a>Yakal</a>
                        <a>(1.871 cu.m)</a>
                        <p>Brgy. Lalakay, Los Banos Laguna </p>
                        <i><a>Apprehended Date:</a></i>
                        <i><a>2018-08-03</a></i>
                    </div>
                    <br>
                    <div class="buttonsDiv">
                        <input class="button" type="button" value="view location">
                        <input class="button" type="button" value="mode details">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
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

              
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle error gracefully, e.g., show an error message to the user
                alert("Error fetching data from the server. See console for details.");
            }
        });
    }
    function redirectToUrl() {
         window.location.href = '/inventory-tree/add-record-view.php'; 
    }

    $(document).ready(function() {
        fetchTitleFromDB(); 
    });
</script>
<?php
include  "../templates/nav-bar2.php"; 
?>
</body>
</html>
