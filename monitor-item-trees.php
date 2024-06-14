<?php
session_start();
require("includes/session.php");
require("includes/darkmode.php");
require("includes/authentication.php");

// Action after logout button
if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

// Set active tab in session
if (isset($_POST['activeTab'])) {
    $_SESSION['activeTab'] = $_POST['activeTab'];
}

// Get the active tab from session
$activeTab = isset($_SESSION['activeTab']) ? $_SESSION['activeTab'] : 'tab1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Item Monitoring</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/Styles/monitor-item-trees.css">

  <script>
    // Save active tab in session via a POST request
    function setActiveTab(tabId) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.style.display = 'none';

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'activeTab';
        input.value = tabId;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
  </script>
</head>
<body>

<?php 
include ("templates/nav-bar.php");
?>

<div class="container">
    <div class="tabset">
    <!-- Tab 1 -->
    <input type="radio" name="tabset" id="tab1" aria-controls="Request" <?php echo ($activeTab == 'tab1') ? 'checked' : ''; ?> onclick="setActiveTab('tab1')">
    <label for="tab1">To Request</label>
    <!-- Tab 2 -->
    <input type="radio" name="tabset" id="tab2" aria-controls="Deliver" <?php echo ($activeTab == 'tab2') ? 'checked' : ''; ?> onclick="setActiveTab('tab2')">
    <label for="tab2">To Deliver</label>
    <!-- Tab 3 -->
    <input type="radio" name="tabset" id="tab3" aria-controls="Receive" <?php echo ($activeTab == 'tab3') ? 'checked' : ''; ?> onclick="setActiveTab('tab3')">
    <label for="tab3">To Receive</label>
    <!-- Tab 4 -->
    <input type="radio" name="tabset" id="tab4" aria-controls="Completed" <?php echo ($activeTab == 'tab4') ? 'checked' : ''; ?> onclick="setActiveTab('tab4')">
    <label for="tab4">Completed</label>
    
    <div class="tab-panels">
        <section id="Request" class="tab-panel">
        <h2>A. Request</h2>
        <p><strong>Request list:</strong> This should be all the list of request per Item (trees)</p>
        
        </section>
        <section id="Deliver" class="tab-panel">
        <h2>B. Deliver</h2>
        <p><strong>Delivery:</strong> This state the current state of items that was approved by Admin to deliver/ donate</p>
        
        </section>
        <section id="Receive" class="tab-panel">
        <h2>C. Receive</h2>
        <p><strong>Receiving:</strong> This is where the state where the item is on the way to its destination</p>
        
        </section>
        <section id="Completed" class="tab-panel">
        <h2>D. Completed</h2>
        <p><strong>Completed:</strong> This is where the items that were received by requester (School)</p>
        
        </section>
    </div>
    
    </div>
</div>

<?php
include "templates/nav-bar2.php"; 
?>
</body>
</html>
