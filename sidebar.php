<?php

// Check if the user is logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // If logged in, get the user's name and position from session variables
    $userName = $_SESSION["username"];
// Assuming "type" is the session variable for the user's position
} else {
    // If not logged in, set default values or redirect to login page
    $userName = "Guest";

}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- third party css -->
        <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- third party css end -->

        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>
    </head>
    <body>
        <div class="leftside-menu">
    
            <!-- LOGO -->
            <a href="index.php" class="logo text-center logo-light">
                <span class="logo-lg">
                    <h2>HYPHER</h2>
                </span>
                <span class="logo-sm">
                    <h2>HYPHER</h2>
                </span>
            </a>
        
            <!-- LOGO -->
            <a href="index.php" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="assets/images/logo-dark.png" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo_sm_dark.png" alt="" height="16">
                </span>
            </a>
        
            <div class="h-100" id="leftside-menu-container" data-simplebar>
        
                <!--- Sidemenu -->
                <ul class="side-nav">
        
                    <li class="side-nav-title side-nav-item">Navigation</li>
        
                    <li class="side-nav-item">
                        <a href="index.php"  class="side-nav-link">
                            <i class="uil-chat-bubble-user"></i>
                            <span> Dashboard</span>
                        </a>
                    </li>
        
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCrm" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                            <i class="uil uil-tachometer-fast"></i>
        
                            <span>Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="side-nav-second-level">
        
                                <li>
                                    <a href="userManagement.php">User's Management</a>
                                </li>
        
                            </ul>
                        </div>
                    </li>
        
                    <li class="side-nav-item">
                        <a href="predict.php"  class="side-nav-link">
                            <i class="uil-search-alt"></i>
                            <span>Heart Attack Risk Prediction</span>
                        </a>
                    </li>
        
                    <li class="side-nav-item">
                        <a href="results.php"  class="side-nav-link">
                            <i class="uil-file-check-alt"></i>
                            <span>Result table</span>
                        </a>
                    </li>
        
        
                    <li class="side-nav-title side-nav-item mt-1">Authentication</li>
        
        
                    <li class="side-nav-item">
                        <a href="logout.php"  class="side-nav-link">
                            <i class="uil-exit"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                    
        
                </ul>
        
        
                <!-- End Sidebar -->
        
                <div class="clearfix"></div>
        
            </div>
            <!-- Sidebar -left -->
        
        </div>
        <!-- Left Sidebar End -->
        
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        
        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="notification-list">
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <span class="account-user-avatar"> 
                                    <img src="assets/images/profile.jpg" alt="user-image" class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name"><?php echo $userName; ?></span>
                                    
                                </span>
                            </a>
                        </li>
                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <div class="app-search dropdown d-none d-lg-block">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control dropdown-toggle"  placeholder="Search..." id="top-search">
                                <span class="mdi mdi-magnify search-icon"></span>
                                <button class="input-group-text btn-primary" type="submit">Search</button>
                            </div>
                        </form>
        
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                      
        
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-notes font-16 me-1"></i>
                                <span>Analytics Report</span>
                            </a>
        
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-life-ring font-16 me-1"></i>
                                <span>How can I help you?</span>
                            </a>
        
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-cog font-16 me-1"></i>
                                <span>User profile settings</span>
                            </a>
                           
                        </div>
                    </div>
                </div>
    </body>
</html>