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
   // echo "<script>alert('This is an alert message!');</script>";
};
?>

<!DOCTYPE html>
<html>
<head>
<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
* {
  box-sizing: border-box;
}

.flex-container {
  display: flex;
  flex-direction: row;
  text-align: center;
  padding:3%;
}
.row2 {
  display: flex;
  flex-direction: row;
  text-align: center;
  padding-left:3%;
  padding-right:3%;
  
}

.flex-item {
  background-color: #f1f1f1;
  padding: 10px;
  flex: 50%;
  font-family: 'Roboto', sans-serif;
  margin-left:5px;
  display: flex; /* Add this line */
  flex-direction: column; /* Add this line */
  border:2px dashed black;
}

.flex-inner-item{
    background-color: #f1f1f1;
    
    flex: 1; /* Adjusted to take up equal space */
    margin-top: 5px; /* Added margin between items */
}

/* Adjust flex direction of inner flex container */
.flex-item .flex-inner-item {
  display: flex;
  flex-direction: row;
  justify-content: center; /* Center items horizontally */
  align-items: center; /* Center items vertically */
}
.flex-qr-container-left{
    margin-right:3px;
    flex: 30%;
    font-size:60px;
    border: 1px solid gray;
}
.flex-qr-container-right{
    flex: 50%;
    /* background-color:yellow; */
    font-size:12px;
}
.flex-container .flex-item button:hover{
  background-color:#D3D3D3;
}

/* Responsive layout - makes a one column-layout instead of two-column layout */
@media (max-width: 800px) {
  .flex-container {
    flex-direction: column; /* Change to row */
  }
  .flex-item-left, .flex-item-right {
    flex-direction: row; /* Each item takes full width */
  }

  /* row 2 */
  .row2 {
    flex-direction: column; /* Change to row */
  }
}
</style>
</head>
<body>
<!-- nav-bar template -->

<?php 
include ("templates/nav-bar.php");
?>

<!-- Print icon button -->
<button  class='btn btn-default' style="border:1px solid #e0e0e0; margin-left: 5px;margin-top:10px;margin-bottom:20px;">
    <i class="bi bi-printer"></i> 
</button>

<div class="flex-container">
  <div class="flex-item">
    <div class="flex-inner-item">
        <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
        <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
    </div>
    <br>
    <button  class='btn btn-default' style="border:1px solid #e0e0e0; padding:6px; ">  
      <span>Remove </span><i class="fas fa-trash"></i> 
    </button>
  </div>

  <div class="flex-item">
    <div class="flex-inner-item">
        <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
        <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
    </div>
    <br>
    <button  class='btn btn-default' style="border:1px solid #e0e0e0; padding:6px; ">  
      <span>Remove </span><i class="fas fa-trash"></i> 
    </button>
  </div>

  <div class="flex-item">
    <div class="flex-inner-item">
        <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
        <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
    </div>
    <br>
    <button  class='btn btn-default' style="border:1px solid #e0e0e0; padding:6px; ">  
      <span>Remove </span><i class="fas fa-trash"></i> 
    </button>
  </div>

  <div class="flex-item">
    <div class="flex-inner-item">
        <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
        <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
    </div>
    <br>
    <button  class='btn btn-default' style="border:1px solid #e0e0e0; padding:6px; ">  
      <span>Remove </span><i class="fas fa-trash"></i> 
    </button>
  </div>

  <div class="flex-item">
    <div class="flex-inner-item">
        <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
        <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
    </div>
    <br>
    <button  class='btn btn-default' style="border:1px solid #e0e0e0; padding:6px; ">  
      <span>Remove </span><i class="fas fa-trash"></i> 
    </button>
  </div>
  
  
</div>

<!-- 2nd row -->
<div class="row2">
    <div class="flex-item">
        <div class="flex-inner-item">
            <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
            <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
        </div>
    </div>

    <div class="flex-item">
        <div class="flex-inner-item">
            <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
            <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
        </div>
    </div>

    <div class="flex-item">
        <div class="flex-inner-item">
            <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
            <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
        </div>
    </div>
    <div class="flex-item">
        <div class="flex-inner-item">
            <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
            <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
        </div>
    </div>
    <div class="flex-item">
        <div class="flex-inner-item">
            <div class="flex-qr-container-left"><i class="fas fa-qrcode" ></i></div>
            <div class="flex-qr-container-right"><strong>Yakal Tree 49 Pcs</strong><br>(1,517 bd. ft)<br>Calamba<br>Februay 6,2020</div>
        </div>
    </div>
</div>
<?php
include  "templates/nav-bar2.php"; 
?>
</body>
</html>
