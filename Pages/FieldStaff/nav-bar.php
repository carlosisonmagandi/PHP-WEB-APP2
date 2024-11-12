<?php
//include("../../includes/darkmode.php");
// Handle form submission for mode change
if(isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    $_SESSION['mode'] = $mode;
    // Redirect to the current page to avoid resubmission prompt
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}


//action after logout button
if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: ../../index.php");
    exit;
   // echo "<script>alert('This is an alert message!');</script>";
};
?>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="/Styles/sb-admin/sb-admin-styles.css" rel="stylesheet" />
        
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <link rel="stylesheet" type="text/css" href="../../Styles/darkmode.css">
        <link rel="stylesheet" type="text/css" href="../../Styles/nav-bar.css">
        <!--  To switch dark mode on or off for notification -->
        <?php 
            if(isset($_SESSION['mode'])){
                if ($_SESSION['mode'] == 'dark') {
                    echo '<link rel="stylesheet" type="text/css" href="../../Styles/notification-dark.css">';
                } else {
                    echo '<link rel="stylesheet" type="text/css" href="../../Styles/notification.css">';
                }
            }else{
                echo '<link rel="stylesheet" type="text/css" href="../../Styles/notification.css">';
            }
        ?>        
    </head>
        
        <!-- <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark"> -->
        <!-- Setting the background color based on the state mode -->
        <nav class="sb-topnav navbar navbar-expand <?php echo ($mode === 'dark') ? 'navbar-dark bg-dark' : 'navbar-light bg-light'; ?> sticky-top">
            
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form id="form-dark-mode" class="d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="POST">
                <div class="dark-mode-container">
                    <div class="input-group">
                        <!-- search bar  -->
                        <input type="hidden" name="mode" value="<?php echo ($mode === 'light') ? 'dark' : 'light'; ?>">
                        <button type="submit" style=" background: <?php echo ($mode === 'light') ? 'none' : 'gray'; ?>; border: 2px solid #c9d6de; cursor: pointer; position: relative; width: 50px; height: 28px; border-radius: 25px; overflow: hidden;">
                            <div style="position: absolute; top: 1px; <?php echo ($mode === 'light') ? 'left: 1px;' : 'right: 1px;'; ?> width: 23px; height: 23px; background-color: <?php echo ($mode === 'light') ? '#f1c40f' : '#f39c12'; ?>; border-radius: 50%; transition: all 0.3s;">
                                <?php if ($mode === 'light'): ?>
                                    <i class="fas fa-moon" style="color:#fff; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i> <!-- Use your preferred icon class for dark mode -->
                                <?php else: ?>
                                    <i class="fas fa-sun" style="color:#fff; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i> <!-- Use your preferred icon class for light mode -->
                                <?php endif; ?>
                            </div>
                        </button>
                    </div>
                </div>

            </form>

            <script>
                $(document).ready(function(){
                    // Function to fetch notification count
                    function fetchNotificationCount() {
                        $.ajax({
                            url: '/fetch-notif-count.php',
                            type: 'GET',
                            success: function(response) {
                                $('#notificationCount').text(response); // Update notification count

                                if (parseInt(response) >= 1) {
                                    $('#notificationCount').show(); // Show the badge
                                } else {
                                    $('#notificationCount').hide(); // Hide the badge
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching notification count:', error);
                            }
                        });
                    }
                    // Call the function initially
                    fetchNotificationCount();
                });
            </script>
            <!-- Notification -->
            <?php if ($_SESSION['session_role']=="Admin"){ ?>
            <div class="notification-bell">
                <button onclick="trigger()" class="btn">🔔</button>
                
                <div class="badge" id="notificationCount"></div>
                
                    <div id="Slider" class="slide-up" >
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="custom-column">
                                    <!-- Second Column Content -->
                                    <?php 
                                        if ($_SESSION['session_role'] == "Admin"){
                                    ?>
                                        <div class="contents"  id="contents-container" >
                                        
                                        </div> 
                                    <?php } else if ($_SESSION['session_role'] == "Staff"){ ?>
                                        <div class="contents" style='display:none'>
                                            <!-- display what ever you want to show as Staff -->
                                        </div> 
                                    <?php } ?>

                                       
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <?php }?>
            <script>
                $(document).ready(function() {
                    function fetchNotifications() {
                        $.ajax({
                            url: '/fetch-notif-div.php',
                            type: 'GET',
                            dataType: 'json', 
                            success: function(data) {
                                // Clear previous notifications
                                $('#contents-container').empty();

                                // Append new notifications
                                data.forEach(function(notification) {
                                    var statusContent = notification.status;
                                    if (notification.status === "seen") {
                                        statusContent += '<span style="font-size:7px;"> &nbsp; &#10004;&#10004;</span>'; 
                                    }

                                    // Create notification element
                                    var $notification = $(
                                        '<div class="notification">' +
                                            '<div class="notification-content">' + notification.title + ' ' + notification.id + '</div>' +
                                            '<div class="notification-time">' + notification.date_created + ' <span style="float:right"><strong>' + notification.time_created + '</strong></span></div>' +
                                            '<div class="status" >' + statusContent + '</div>' +
                                        '</div>'
                                        );


                                    //click listener
                                    $notification.click(function() {

                                        $.ajax({
                                            type: "POST",
                                            url: "/templates/nav-bar-update-pushedNotif.php", 
                                            data: { id: notification.id },
                                            success: function(response) {
                                                console.log(response); 
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                console.error(textStatus, errorThrown); // error handling
                                            }
                                        });
                                        if(notification.title=="Account Registration"){
                                            //alert(notification.id);
                                            window.location.href = '/Pages/admin/manageAccounts.php?user_name=' + notification.user_name;
                                        }
                                        
                                    });

                                    // Append notification to container
                                    $('#contents-container').append($notification);
                                });
                            },
                            error: function(xhr, status, error) {
                                //console.error('Error fetching notifications:', error);
                            }
                        });
                    }

                    // Fetch notifications initially
                    fetchNotifications();
                });
            </script>

            <script src="/Javascript/sb-admin/notification-script.js"></script>

            <!-- Navbar-->
            <ul class="navbar-nav" >
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/Pages/admin/manageOwnAccount.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                        <form method="post" action="">
                            <input class="dropdown-item" type="submit" name="Logout" value="Logout">    
                        </form>
                            
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <!-- <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion"> -->
                <!-- <nav class="sb-sidenav accordion <?php echo getModeClass($mode); ?>" id="sidenavAccordion">' -->
                
                <!-- setting border color once in dark mode state -->
                <?php 
                    if (getModeClass($mode) == 'sb-sidenav-dark'){
                        echo '<nav class="sb-sidenav accordion ' . getModeClass($mode) . '" id="sidenavAccordion" style="border-right:3px solid #282c37">';
                    } else {
                        echo '<nav class="sb-sidenav accordion ' . getModeClass($mode) . '" id="sidenavAccordion" >';
                    }
                ?>
                    <!-- Navbar Brand-->
                    <div class="navbar-brand">
                        <br><img src="/Images/PENRO-LOGO.png" alt="PENRO Logo" class="logo">
                    </div>
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="/Pages/FieldStaff/dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>

                            <?php if ($_SESSION['session_role']=="Admin"){
                                    echo '
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                        Account Management
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="/Pages/admin/manageAccounts.php">Manage Accounts</a>
                                            <a class="nav-link" href="/Pages/admin/manageRoles.php">Manage Roles</a>
                                        </nav>
                                    </div>';
                                }
                            ?>
                                <!-- display if role is admin -->
                            
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePages">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                    Monitoring
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapsePassword" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseRequest" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                            Incident Reports
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="pagesCollapseRequest" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link" href="/monitor-item-trees.php">Forest Products</a>
                                                <a class="nav-link" href="register.html">Equipment</a>
                                                <a class="nav-link" href="password.html">Conveyance</a>
                                            </nav>
                                        </div>

                                        <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                            Confiscations
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link" href="401.html">Forest Products</a>
                                                <a class="nav-link" href="404.html">Closed case</a>
                                            </nav>
                                        </div> -->

                                        <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseDonations" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                            Donations
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="pagesCollapseDonations" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link" href="/Admin/Monitoring/monitoring-display.php">Forest Products</a>
                                                <a class="nav-link" href="register.html">Equipment</a>
                                                <a class="nav-link" href="password.html">Vehicle</a>
                                            </nav>
                                        </div> -->
                                    </nav>
                                </div>
                            <!--  -->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInventory" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                                My Tickets 
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseInventory" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseTrees" aria-expanded="false" aria-controls="pagesCollapseTrees">
                                        Reported Incidents
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseTrees" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="/Pages/FieldStaff/MyTickets/view-all-incidents.php">View All</a>
                                            <a class="nav-link" href="/Pages/FIeldStaff/MyTickets/view-assign-to-me.php">Assigned to me</a>
                                        </nav>
                                    </div>
                                    <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseVehicle" aria-expanded="false" aria-controls="pagesCollapseVehicle">
                                        Donations 
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseVehicle" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="/Pages/FieldStaff/MyTickets/view-all-incidents.php">View All</a>
                                            <a class="nav-link" href="/vehicles/vehicle-card-view.php">Assigend to me</a>
                                        </nav>
                                    </div> -->
                                    
                                   
                                </nav>
                            </div>
                           
                            

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">
                            <strong>Logged in as:</strong> 
                            <?php 
                            // include("../../includes/session.php");
                            // echo $username; 
                            echo $_SESSION['session_username'];
                            ?>
                        </div>
                        <strong>Role:</strong> <?php echo $_SESSION['session_role'];?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
                    