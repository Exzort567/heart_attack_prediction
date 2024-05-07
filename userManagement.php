<?php
session_start();
include ('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $user = $_POST['username']; 
    $pass = $_POST['password']; 
    $type = $_POST['type'];

    // Check if the password matches
    $confirmPassword = $_POST['confirm_password'];
    if ($pass != $confirmPassword) {
        echo '<script>alert("Password do not match. Please try again.");</script>';
        echo '<script>history.back();</script>';
        exit;
    }

    // Check if the username is already taken
    $checkUsernameQuery = "SELECT username FROM user WHERE username = ?";
    $checkUsernameStmt = $conn->prepare($checkUsernameQuery);
    $checkUsernameStmt->bind_param("s", $user);
    $checkUsernameStmt->execute();
    $checkUsernameResult = $checkUsernameStmt->get_result();

    if ($checkUsernameResult->num_rows > 0) {
        echo '<script>alert("Username is already taken. Please choose a different username.");</script>';
        echo '<sc   ript>history.back();</script>';
        exit;
    }

    // Hashing password
    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
   
    $sql = "INSERT INTO user (fname, lname, mname, username, type, password) VALUES ('$fname', '$lname', '$mname', '$user', '$type', '$hashed_password')";    
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Added new user successfully")</script>';
        echo '<script>setTimeout(function(){ window.location.href = "login.php"; }, 1000);</script>'; // Add delay before redirecting
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if the user is logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // If logged in, get the user's name and position from session variables
    $userName = $_SESSION["username"];
} else {
    // If not logged in, set default values or redirect to login page
    $userName = "Guest";

}

$sql = "SELECT user_id, lname, fname, mname, username, type FROM user";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from coderthemes.com/hyper/saas/crm-orders-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 Jul 2022 10:20:49 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Manage User</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>

    </head>

    <body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php include 'sidebar.php'; ?>
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    
                                    <h4 class="page-title">User's Management</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-xl-8">
                                                                         
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="text-xl-end mt-xl-0 mt-2">
                                                    <button type="button" class="btn btn-primary" onclick="redirectToRegister()">Add new user</button>
                                                  
                                                </div>  
                                            </div><!-- end col-->
                                        </div>
                
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>User Id</th>
                                                        <th>Last Name</th>
                                                        <th>First Name</th>
                                                        <th>Middle Name</th>
                                                        <th>Username</th>
                                                        <th>Type</th>
                                                        <th style="width: 125px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // Iterate over the fetched user data and populate table rows
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<tr>";
                                                            echo "<td>{$row['user_id']}</td>";
                                                            echo "<td>{$row['lname']}</td>";
                                                            echo "<td>{$row['fname']}</td>";
                                                            echo "<td>{$row['mname']}</td>";
                                                            echo "<td>{$row['username']}</td>";
                                                            echo "<td>{$row['type']}</td>";
                                                            echo "<td>";
                                                            // EDIT BUTTON
                                                            echo "<a href='edit_user.php?id={$row['user_id']}' class='btn btn-primary'>Edit</a>";

                                                            // DELETE BUTTON 
                                                            echo "<form action='delete_user.php' method='post'>";
                                                            echo "<input type='hidden' name='id' value='{$row['user_id']}'>";
                                                            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                                            echo "</form>";
                                                            echo "</td>";
                                                            echo "</tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div> <!-- end row --> 
                    </div> <!-- container -->
                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <div class="modal fade" id="addUserModal" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xxl-4 col-lg-5">
                            <div class="card">
                                <!-- Logo-->
                                <div class="card-header pt-4 pb-4 text-center bg-primary">
                                    <a href="index.html">
                                        <span><img src="assets/images/logo.png" alt="" height="18"></span>
                                    </a>
                                </div>
            
                                <div class="card-body p-4">
                                    <div class="text-center w-75 m-auto">
                                        <h4 class="text-dark-50 text-center mt-0 fw-bold">Free Sign Up</h4>
                                        <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
                                    </div>
            
                                    <form method="post" action="register.php"> <!-- assuming PHP script name is register.php -->
            
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">First name</label>
                                            <input class="form-control" type="text" name="fname" placeholder="Enter your first name" required>
                                        </div>
            
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Last name</label>
                                            <input class="form-control" type="text" name="lname" placeholder="Enter your last name" required>
                                        </div>
            
                                        <div class="mb-3">
                                            <label for="middlename" class="form-label">Middle name</label>
                                            <input class="form-control" type="text" name="mname" placeholder="Enter your middle name" required>
                                        </div>
            
                                        <div class="mb-3">
                                            <label for="type">Type:</label>
                                            <select name="type" id="type">
                                                <option value="staff">Staff</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
            
            
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">Username</label>
                                            <input class="form-control" type="text" name="username" required placeholder="Enter your email">
                                        </div>
            
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" name="password" class="form-control" placeholder="Enter your password">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="mb-3">
                                            <label for="confirmPassword" class="form-label">Confirm password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" name="confirm_password" class="form-control" placeholder="Enter your password">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
            
            
                                        <div class="mb-3 text-center">
                                            <input type="submit" value="Register">
                                        </div>
            
                                    </form>
                                </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->
            
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted">Already have account? <a href="pages-login.html" class="text-muted ms-1"><b>Log In</b></a></p>
                                </div> <!-- end col-->
                            </div>
                            <!-- end row -->
            
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="end-bar">

            <div class="rightbar-title">
                <a href="javascript:void(0);" class="end-bar-toggle float-end">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <div class="rightbar-content h-100" data-simplebar>

                <div class="p-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                    </div>

                    <!-- Settings -->
                    <h5 class="mt-3">Color Scheme</h5>
                    <hr class="mt-1" />

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light" id="light-mode-check" checked>
                        <label class="form-check-label" for="light-mode-check">Light Mode</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark" id="dark-mode-check">
                        <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                    </div>
       

                    <!-- Width -->
                    <h5 class="mt-4">Width</h5>
                    <hr class="mt-1" />
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="width" value="fluid" id="fluid-check" checked>
                        <label class="form-check-label" for="fluid-check">Fluid</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="width" value="boxed" id="boxed-check">
                        <label class="form-check-label" for="boxed-check">Boxed</label>
                    </div>
        

                    <!-- Left Sidebar-->
                    <h5 class="mt-4">Left Sidebar</h5>
                    <hr class="mt-1" />
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="theme" value="default" id="default-check">
                        <label class="form-check-label" for="default-check">Default</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="theme" value="light" id="light-check" checked>
                        <label class="form-check-label" for="light-check">Light</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="theme" value="dark" id="dark-check">
                        <label class="form-check-label" for="dark-check">Dark</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="fixed" id="fixed-check" checked>
                        <label class="form-check-label" for="fixed-check">Fixed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="condensed" id="condensed-check">
                        <label class="form-check-label" for="condensed-check">Condensed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="scrollable" id="scrollable-check">
                        <label class="form-check-label" for="scrollable-check">Scrollable</label>
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
            
               
                    </div>
                </div> <!-- end padding-->

            </div>
        </div>

        <div class="rightbar-overlay"></div>
        <!-- /End-bar -->


        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>
        <script>
            function redirectToRegister() {
                // Redirect to the register page
                window.location.href = "register.php";
                
                // Trigger the modal to open after the redirection
                $('#addUserModal').modal('show');
            }
        </script>
    </body>

<!-- Mirrored from coderthemes.com/hyper/saas/crm-orders-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 Jul 2022 10:20:50 GMT -->
</html>
