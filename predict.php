<?php
include ('session.php');
include ('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $cp = $_POST['cp'];
    $trtbps = $_POST['trtbps']; 
    $chol = $_POST['chol']; 
    $fbs = $_POST['fbs'];
    $restecg= $_POST['restecg'];
    $thalachh = $_POST['thalachh'];
    $exng = $_POST['exng'];
    $oldpeak = $_POST['oldpeak']; 
    $slp = $_POST['slp']; 
    $caa = $_POST['caa'];
    $thall = $_POST['thall']; 

    // Prepare and execute the SQL query to insert form data into the table
    $sql = "INSERT INTO heart_attack (age, sex, cp, trtbps, chol, fbs, restecg, thalachh, exng, oldpeak, slp, caa, thall) 
            VALUES ('$age', '$sex', '$cp', '$trtbps', '$chol', '$fbs', '$restecg', '$thalachh', '$exng', '$oldpeak', '$slp', '$caa', '$thall')";        

    if (mysqli_query($conn, $sql)) {
        echo '<script> alert("Added successfully")</script> ';
        header("Location: results.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Construct and execute the command to call the Python script for prediction
    $command = "python classify.py logistic_regression_model.pkl $age $sex $cp $trtbps $chol $fbs $restecg $thalachh $exng $oldpeak $slp $caa $thall";

    // Capture the prediction result
    $prediction = exec($command);

    // Map the prediction result to 0 or 1 for database storage
    $predicted_value = ($prediction === "More chance of heart attack") ? 1 : 0;

    // Update the table with the prediction result
    $update_sql = "UPDATE heart_attack SET output = '$predicted_value' ORDER BY user_id DESC LIMIT 1"; 
    if (mysqli_query($conn, $update_sql)) {
        echo '<script> alert("Prediction: ' . $prediction . '")</script>';
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from coderthemes.com/hyper/saas/form-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 Jul 2022 10:21:33 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Form Elements | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
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
                                    <div class="page-title-right">
                                
                                    </div>
                                    <h4 class="page-title">Prediction Dataset</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Input Types</h4>
                                        <p class="text-muted font-14">
                                            Heart Attack Analysis & Prediction Dataset

                                        <ul class="nav nav-tabs nav-bordered mb-3">
                                            <li class="nav-item">
                                                <a href="#input-types-preview" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                                    Input
                                                </a>
                                            </li>
                                           
                                        </ul> <!-- end nav-->

                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="input-types-preview">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <form action="predict.php" method="post">
                                                        <form action="predict.php" method="post">
                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Age</label>
                                                                <input name="age" type="number" id="simpleinput" class="form-control">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="example-multiselect" class="form-label">Chest Pain Type (CP):</label>
                                                                <select name="cp" id="example-multiselect" multiple class="form-control">
                                                                    <option value="0">Typical Angina</option>
                                                                    <option value="1">Atypical Angina</option>
                                                                    <option value="3">Non-Anginal Pain</option>
                                                                    <option value="4">Asymptomatic</option>
                                                                </select>
                                                            </div>
        
                                                            <div class="mb-3">
                                                                <label for="example-email" class="form-label">Cholesterol in mg/dl fetched via BMI sensor:</label>
                                                                <input type="text" id="example-email" name="chol" class="form-control" placeholder="e.g., 234">
                                                            </div>
        
                                                            <div class="mb-3">
                                                                <label for="example-multiselect" class="form-label">Resting electrocardiographic results:</label>
                                                                <select name="restecg" id="example-multiselect" multiple class="form-control">
                                                                    <option value="0">Normal</option>
                                                                    <option value="1">Abnormal ST-T wave (changes in wave patterns)</option>
                                                                    <option value="2">Likely or definite left ventricular hypertrophy (heart muscle thickening)</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="example-multiselect" class="form-label">Slope of the peak exercise ST segment:</label>
                                                                <select name="slp" id="example-multiselect" multiple class="form-control">
                                                                    <option value="0">Upsloping</option>
                                                                    <option value="1">Flat</option>
                                                                    <option value="2">Downsloping</option>
                                                                </select>
                                                            </div>
                
                                                            <div class="mb-3">
                                                                <label for="example-multiselect" class="form-label">Slope of the peak exercise ST segment:</label>
                                                                <select name="thall" id="example-multiselect" multiple class="form-control">
                                                                    <option value="0">Normal</option>
                                                                    <option value="1">Fixed defect</option>
                                                                    <option value="2">Reversible defect</option>
                                                                </select>
                                                            </div>
        
                                                        
                                                    </div> <!-- end col -->
        
                                                    <div class="col-lg-6">
                                                        <form action="predict.php" method="post">
                
                                                            <div class="mb-3">
                                                                <label for="example-select" class="form-label">Sex:</label>
                                                                <select name="sex" class="form-select" id="example-select">
                                                                    <option>Select</option>
                                                                    <option value="1">Male</option>
                                                                    <option value="0">Female</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Resting blood pressure (in mm Hg):</label>
                                                                <input name="trtbps" type="number" id="simpleinput" class="form-control" placeholder="e.g., 130">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="example-select" class="form-label">Fasting blood sugar > 120 mg/dl:</label>
                                                                <select name="fbs" class="form-select" id="example-select">
                                                                    <option>Select</option>
                                                                    <option value="1">True</option>
                                                                    <option value="0">False</option>
                                                                </select>
                                                            </div>
                                                                          
                                                            <div class="mb-3">
                                                                <label for="example-email" class="form-label">The person's maximum heart rate achieved:</label>
                                                                <input type="number" id="example-email" name="thalachh" class="form-control" placeholder="e.g., 82">
                                                            </div>
                
                                                            <div class="mb-3">
                                                                <label for="example-select" class="form-label">Exercise induced angina:</label>
                                                                <select name="exng" class="form-select" id="example-select">
                                                                    <option>Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>
                
                                                            <div class="mb-3">
                                                                <label for="example-email" class="form-label">ST depression induced by exercise relative to rest:</label>
                                                                <input type="number" id="example-email" step="0.01" name="oldpeak" class="form-control" placeholder="e.g., 1.2">
                                                            </div>
                
                                                            <div class="mb-3">
                                                                <label for="example-email" class="form-label">Number of major vessels (0-3) colored by flourosopy:</label>
                                                                <input type="number" id="example-email" min="0" max="3" name="caa" class="form-control" placeholder="e.g., 2">
                                                            </div>  
                                                            
                                                            
                
                                                        
                                                        <button type="submit" class="btn btn-primary">Primary</button>
                                                        </form>
                                                        </form>
                                                        </form>
                                                    </div> <!-- end col -->
                                                </div>
                                                <!-- end row-->                      
                                            </div> <!-- end preview-->
                                        
            
                        <!-- end row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


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
        
    </body>

<!-- Mirrored from coderthemes.com/hyper/saas/form-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 Jul 2022 10:21:34 GMT -->
</html>
