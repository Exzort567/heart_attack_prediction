<?php

include ('session.php');
include ('connection.php');

if (($_SERVER["REQUEST_METHOD"] == "POST")) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $user = $_POST['username']; 
    $pass = $_POST['password']; 
    $type = $_POST['type'];


    // Check if the password is match
    $confirmPassword = $_POST['confirm_password'];
    if ($pass != $confirmPassword) {
        echo'<script>alert("Password do not match. Please try again.");</script>';
        echo '<script>history.back();</script>';
        exit;
    };

    // Check if the username is already taken
    $checkUsernameQuery = "SELECT username FROM user WHERE username = ?";
    $checkUsernameStmt = $conn -> prepare ($checkUsernameQuery);
    $checkUsernameStmt -> bind_param ("s", $user);
    $checkUsernameStmt -> execute();
    $checkUsernameResult = $checkUsernameStmt -> get_result();

    if ($checkUsernameResult -> num_rows > 0) {
        echo '<script>alert("Username is already taken. Please choose a different username.");</script>';
        echo '<script>history.back();</script>';
        exit;
    };


    // Hashing password
    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
   
    $sql = "INSERT INTO user (fname, lname, mname, username, type, password) VALUES ('$fname', '$lname', '$mname', '$user', '$type', '$hashed_password')";    
    if (mysqli_query($conn, $sql)) {
        echo '<script> alert("Added new user successfully")</script> ';
        echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 1000);</script>'; // Add delay before redirecting
      
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Add User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>
</head>

<body class="loading authentication-bg" data-layout-config='{"darkMode":false}'>

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
                            <h4 class="text-dark-50 text-center mt-0 fw-bold">Add new user</h4>
                
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
                                <button type="submit" class="btn btn-primary rounded-pill">Submit</button>
                            </div>
                            <div class="mb-3 text-center">
                                <a href="userManagement.php"><button type="button" class="btn btn-info rounded-pill">Cancel</button></a>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<!-- bundle -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>

</body>
</html>