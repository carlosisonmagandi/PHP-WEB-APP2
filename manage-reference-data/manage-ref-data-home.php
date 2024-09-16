<?php 
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");

// Action after logout button
if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

// echo "<script>alert('" . $_SESSION['activeTabName'] . "');</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reference data </title>
    
    <?php
        
        // Output the appropriate stylesheet based on $_SESSION['mode']
        if ($_SESSION['mode'] == 'light') {
            echo '<link rel="stylesheet" type="text/css" href="/Styles/manage-ref-data-home.css">';
        } else if ($_SESSION['mode'] == 'dark') {
            echo '<link rel="stylesheet" type="text/css" href="/Styles/manage-ref-data-home-dm.css">';
        }
    ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php 
include("../templates/nav-bar.php");
?>

<div class="container">
    <div class="centered">
        <a class="button" data-text="Trees" data-href="/manage-reference-data/manage-ref-data.php"><i class="fas fa-tree"></i></a>
        <a class="button" data-text="Vehicle" data-href="#"><i class="fas fa-car"></i></a>
        <a class="button" data-text="Equipment" data-href="/manage-equipments-ref-data/equipment-reference-data.php"><i class="fas fa-tools"></i></a>
    </div>
</div>

<script>
// Get all anchor tags with class 'button'
const buttons = document.querySelectorAll('.button');

buttons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); 
        const text = this.getAttribute('data-text'); 
        $.ajax({
            url: '/manage-reference-data/manage-ref-data-tab-name.php',
            type: 'POST',
            data: { tabName: text }, 
            success: function(response) {
                // console.log("Session set for " + text + response);
                //sessionStorage.setItem('tabName',response);
            },
            error: function() {
                console.error("An error occurred ");
            }
        });

        // Redirect if href exists and is not '#'
        const href = this.getAttribute('data-href');
        if (href && href !== "#") {
            window.location.href = href; 
        }
    });
});
</script>




<?php 
include("../templates/nav-bar2.php");
?>
</body>
</html>
