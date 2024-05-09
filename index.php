<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // If logged in, get the user's name and position from session variables
    $userName = $_SESSION["username"];
   
} else {
    // If not logged in, set default values or redirect to login page
    $userName = "Guest";
   
}

// Fetch data from the database for ages and chol
$sql = "SELECT * FROM heart_attack";
$result = mysqli_query($conn, $sql);

// Initialize arrays to store data for each chart
$ages = [];
$chol = [];
// Add more arrays for other columns if needed

// Fetch data and populate arrays
while ($row = mysqli_fetch_assoc($result)) {
    $ages[] = $row['age'];
    $chol[] = $row['chol'];
    // Add more columns as needed
}

// Fetch data from the database for sex and cp
$sql = "SELECT * FROM heart_attack";
$result = mysqli_query($conn, $sql);

// Initialize arrays to store data for each chart
$sexes = [];
$chestPain = [];

// Fetch data and populate arrays
while ($row = mysqli_fetch_assoc($result)) {
    $sexes[] = $row['sex'];
    $chestPain[] = $row['cp'];
}

// Fetch data from the database for thalachh and oldpeak
$sql = "SELECT * FROM heart_attack";
$result = mysqli_query($conn, $sql);

// Initialize arrays to store data for each chart
$thalachh = [];
$oldpeak = [];

// Fetch data and populate arrays
while ($row = mysqli_fetch_assoc($result)) {
    $thalachh[] = $row['thalachh'];
    $oldpeak[] = $row['oldpeak'];
}

// Fetch data from the database for thalachh and cp
$sql = "SELECT * FROM heart_attack";
$result = mysqli_query($conn, $sql);

// Initialize arrays to store data for each chart
$thalachh = [];
$chestPain = [];

// Fetch data and populate arrays
while ($row = mysqli_fetch_assoc($result)) {
    $thalachh[] = $row['thalachh'];
    $chestPain[] = $row['cp'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Heart Attack Prediction</title>
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

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

</head>

<body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'sidebar.php'; ?>
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->


                <!-- Repeat the above structure for other cards -->

            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Line Chart</h4>
                            <div dir="ltr">
                                <div class="mt-3 chartjs-chart" style="height: 400px; overflow-y: auto;">
                                    <!-- Canvas for the chart -->
                                    <canvas id="ageChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Bar Chart</h4>
                            <div dir="ltr">
                                    <div class="mt-3 chartjs-chart" style="height: 400px; overflow-y: auto;">
                                    <!-- Canvas for the chart -->
                                    <canvas id="cholChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
                
            </div>
            <!-- end row-->
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Donut Chart</h4>
                            <div dir="ltr">
                                <div class="mt-3 chartjs-chart" style="height: 400px; overflow-y: auto;">
                                    <!-- Canvas for the chart -->
                                    <canvas id="sexChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Line Chart</h4>
                            <div dir="ltr">
                                    <div class="mt-3 chartjs-chart" style="height: 400px; overflow-y: auto;">
                                    <!-- Canvas for the chart -->
                                    <canvas id="chestPainChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
                
            </div>
            <!-- end row-->
            <div class="row">
            <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Bubble Chart</h4>
                            <div dir="ltr">
                                    <div class="mt-3 chartjs-chart" style="height: 400px; overflow-y: auto;">
                                    <!-- Canvas for the chart -->
                                    <canvas id="bubbleChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div> <!-- container -->
        
    </div> <!-- content -->
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
        <!-- JavaScript to render the line chart -->
    <script>
        // Get data from PHP arrays
        var agesData = <?php echo json_encode($ages); ?>;
        var cholData = <?php echo json_encode($chol); ?>;
        // Add more variables for other columns if needed

        // Chart.js code to render charts
        var ageCtx = document.getElementById('ageChart').getContext('2d');
        var cholCtx = document.getElementById('cholChart').getContext('2d');
        // Add more contexts for other charts if needed

        var ageChart = new Chart(ageCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(range(1, count($ages))); ?>,
                datasets: [{
                    label: 'Age',
                    data: agesData,
                    borderColor: 'blue',
                    borderWidth: 1
                }]
            },
            options: {}
        });

        var cholChart = new Chart(cholCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(range(1, count($chol))); ?>,
                datasets: [{
                    label: 'Cholesterol',
                    data: cholData,
                    backgroundColor: 'green'
                }]
            },
            options: {}
        });
        // Get data from PHP arrays
        var sexesData = <?php echo json_encode($sexes); ?>;
        var chestPainData = <?php echo json_encode($chestPain); ?>;

        // Chart.js code to render charts
        var sexCtx = document.getElementById('sexChart').getContext('2d');
        var chestPainCtx = document.getElementById('chestPainChart').getContext('2d');

        var sexChart = new Chart(sexCtx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    label: 'Sex',
                    data: sexesData,
                    backgroundColor: ['blue', 'pink']
                }]
            },
            options: {}
        });

        var chestPainChart = new Chart(chestPainCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(range(1, count($chestPain))); ?>,
                datasets: [{
                    label: 'Chest Pain Type',
                    data: chestPainData,
                    borderColor: 'red',
                    borderWidth: 1
                }]
            },
            options: {}
        });
        // Get data from PHP arrays
        var thalachhData = <?php echo json_encode($thalachh); ?>;
        var oldpeakData = <?php echo json_encode($oldpeak); ?>;

        // Prepare data for bubble chart
        var bubbleChartData = [];
        for (var i = 0; i < thalachhData.length; i++) {
            bubbleChartData.push({
                x: thalachhData[i],
                y: oldpeakData[i],
                r: 10 // Set a fixed radius for all bubbles for simplicity
            });
        }

        // Chart.js code to render bubble chart
        var bubbleCtx = document.getElementById('bubbleChart').getContext('2d');

        var bubbleChart = new Chart(bubbleCtx, {
            type: 'bubble',
            data: {
                datasets: [{
                    label: 'Thalachh vs Oldpeak',
                    data: bubbleChartData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)'
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: {
                            display: true,
                            text: 'Maximum Heart Rate Achieved (Thalachh)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'ST Depression Induced by Exercise Relative to Rest (Oldpeak)'
                        }
                    }
                }
            }
        });
        // Get data from PHP arrays
        var thalachhData = <?php echo json_encode($thalachh); ?>;
        var chestPainData = <?php echo json_encode($chestPain); ?>;

        // Chart.js code to render radar chart
        var radarCtx = document.getElementById('radarChart').getContext('2d');

        var radarChart = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: ['Thalachh', 'Chest Pain Type'],
                datasets: [{
                    label: 'Heart Parameters',
                    data: [
                        [thalachhData[0], chestPainData[0]],
                        [thalachhData[1], chestPainData[1]],
                        [thalachhData[2], chestPainData[2]],
                        [thalachhData[3], chestPainData[3]]
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    r: {
                        suggestedMin: 0,
                        suggestedMax: 200
                    }
                }
            }
        });

        
    </script>


    <!-- bundle -->

    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <!-- third party js -->
    <!-- <script src="assets/js/vendor/chart.min.js"></script> -->
    <script src="assets/js/vendor/apexcharts.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="assets/js/pages/demo.dashboard-analytics.js"></script>
    <!-- end demo js-->
</body>
</html>
