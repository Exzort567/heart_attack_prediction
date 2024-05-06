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

// Fetch count of male individuals
$sql_male_count = "SELECT COUNT(*) AS male_count FROM heart_attack WHERE Sex = '1'";
$result_male_count = mysqli_query($conn, $sql_male_count);
$row_male_count = mysqli_fetch_assoc($result_male_count);
$maleCount = $row_male_count['male_count'];

// Fetch count of female individuals
$sql_female_count = "SELECT COUNT(*) AS female_count FROM heart_attack WHERE Sex = '0'";
$result_female_count = mysqli_query($conn, $sql_female_count);
$row_female_count = mysqli_fetch_assoc($result_female_count);
$femaleCount = $row_female_count['female_count'];

// Fetch data from the database for male
$sql_male = "SELECT AVG(trtbps) AS avg_trtbps, AVG(cp) AS avg_cp, AVG(chol) AS avg_chol, AVG(fbs) AS avg_fbs, AVG(restecg) AS avg_restecg, AVG(thalachh) AS avg_thalachh, AVG(exng) AS avg_exng, AVG(oldpeak) AS avg_oldpeak, AVG(slp) AS avg_slp, AVG(caa) AS avg_caa, AVG(thall) AS avg_thall FROM heart_attack WHERE Sex = '1'";
$result_male = mysqli_query($conn, $sql_male);

// Fetch data from the database for female
$sql_female = "SELECT AVG(trtbps) AS avg_trtbps, AVG(cp) AS avg_cp, AVG(chol) AS avg_chol, AVG(fbs) AS avg_fbs, AVG(restecg) AS avg_restecg, AVG(thalachh) AS avg_thalachh, AVG(exng) AS avg_exng, AVG(oldpeak) AS avg_oldpeak, AVG(slp) AS avg_slp, AVG(caa) AS avg_caa, AVG(thall) AS avg_thall FROM heart_attack WHERE Sex = '0'";
$result_female = mysqli_query($conn, $sql_female);

// Array to store column names
$columns = ['trtbps', 'cp', 'chol', 'fbs', 'restecg', 'thalachh', 'exng', 'oldpeak', 'slp', 'caa', 'thall'];

// Arrays to store average values for male and female
$avg_male = [];
$avg_female = [];

// Fetch average values for male
if (mysqli_num_rows($result_male) > 0) {
    $row_male = mysqli_fetch_assoc($result_male);
    foreach ($columns as $column) {
        $avg_male[] = $row_male["avg_".$column];
    }
}

// Fetch average values for female
if (mysqli_num_rows($result_female) > 0) {
    $row_female = mysqli_fetch_assoc($result_female);
    foreach ($columns as $column) {
        $avg_female[] = $row_female["avg_".$column];
    }
}

// Fetch data from the database
$sql = "SELECT Age, AVG(thalachh) AS avg_thalachh FROM heart_attack GROUP BY Age";
$result = mysqli_query($conn, $sql);

// Arrays to store age and average thalachh values
$ageData = [];
$averageThalachhData = [];

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $ageData[] = $row["Age"];
        $averageThalachhData[] = $row["avg_thalachh"];
    }
}
$modifiedLabels = [];
foreach ($ageData as $index => $ageRange) {
 // Combine age range and average thalachh value
    $modifiedLabels[] = 'Age: ' . $ageRange . ', Avg Thalachh: ' . $averageThalachhData[$index];
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
                                    <canvas id="line-chart-example" data-colors="#727cf5,#0acf97"></canvas>
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
                                    <canvas id="bar-chart-example" data-colors="#fa5c7c,#727cf5"></canvas>
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
                                    <canvas id="donut-chart-example"></canvas>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Step Chart</h4>
                            <div dir="ltr">
                                    <div class="mt-3 chartjs-chart" style="height: 400px; overflow-y: auto;">
                                    <!-- Canvas for the chart -->
                                    <canvas id="step-chart-example" data-colors="#fa5c7c,#727cf5"></canvas>
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
                                    <canvas id="bubble-chart-example" data-colors="#fa5c7c,#727cf5"></canvas>
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
        document.addEventListener('DOMContentLoaded', function() {
            var ctxLine = document.getElementById('line-chart-example').getContext('2d');
            var myLineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    // Labels for X-axis (Age)
                    labels: <?php echo json_encode($ageData); ?>,
                    datasets: [{
                        label: 'Average thalachh',
                        data: <?php echo json_encode($averageThalachhData); ?>,
                        backgroundColor: 'rgba(114, 124, 245, 0.2)', // Color for the line fill
                        borderColor: 'rgba(114, 124, 245, 1)', // Color for the line
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgba(114, 124, 245, 1)', // Color for the points
                        pointBorderColor: '#fff',
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(114, 124, 245, 1)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false, // Change to true if you want the Y-axis to start from zero
                            // Add label for Y-axis
                            title: {
                                display: true,
                                text: 'Average thalachh'
                            }
                        },
                        x: {
                            // Add label for X-axis
                            title: {
                                display: true,
                                text: 'Age'
                            }
                        }
                    }
                }
            });
        });

        // JavaScript to render the bar chart
        document.addEventListener('DOMContentLoaded', function() {
            var ctxBar = document.getElementById('bar-chart-example').getContext('2d');
            var myBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    // Labels for X-axis (Gender)
                    labels: ['Male', 'Female'],
                    datasets: [{
                        label: 'Average Resting Blood Pressure (trtbps)',
                        // Data for Y-axis (Resting Blood Pressure)
                        data: <?php echo json_encode([$avg_male[0], $avg_female[0]]); ?>,
                        backgroundColor: ['rgba(114, 124, 245, 0.2)', 'rgba(245, 114, 124, 0.2)'], // Fill color for the bars
                        borderColor: ['rgba(114, 124, 245, 1)', 'rgba(245, 114, 124, 1)'], // Border color for the bars
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true, // Start Y-axis from zero
                            // Add label for Y-axis
                            title: {
                                display: true,
                                text: 'Average Resting Blood Pressure (trtbps)'
                            }
                        },
                        x: {
                            // Add label for X-axis
                            title: {
                                display: true,
                                text: 'Gender'
                            }
                        }
                    }
                }
            });
        });
       // JavaScript to render the donut chart
        document.addEventListener('DOMContentLoaded', function() {
            var ctxDonut = document.getElementById('donut-chart-example').getContext('2d');
            
            var myDonutChart = new Chart(ctxDonut, {
                
                type: 'doughnut',
                data: {
                    // Labels for different categories (e.g., Age groups)
                    labels: <?php echo json_encode($modifiedLabels); ?>,
                    datasets: [{
                        label: 'Donut Chart',
                        // Data for each category (e.g., Average thalachh for each age group)
                        data: <?php echo json_encode($averageThalachhData); ?>,
                        backgroundColor: [
                            // Specify different colors for each category as needed
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)'
                        ],
                        borderColor: [
                            // Specify border colors corresponding to the background colors
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutout: '70%', // Adjust the size of the hole in the center of the doughnut
                    plugins: {
                        title: {
                            display: true,
                            text: 'Donut'
                        }
                    }
                }
            });
        });



        // JavaScript to render the bubble chart
        document.addEventListener('DOMContentLoaded', function() {
            var ctxBubble = document.getElementById('bubble-chart-example').getContext('2d');
            var myBubbleChart = new Chart(ctxBubble, {
                type: 'bubble',
                data: {
                    datasets: [{
                        label: 'Bubble Chart',
                        data: [
                            {x: <?php echo $avg_male[0]; ?>, y: <?php echo $avg_female[0]; ?>, r: 10},
                            // Add more data points as needed
                        ],
                        backgroundColor: 'rgba(114, 124, 245, 0.2)', // Fill color for bubbles
                        borderColor: 'rgba(114, 124, 245, 1)', // Border color for bubbles
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Average trtbps (Male)'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Average trtbps (Female)'
                            }
                        }
                    }
                }
            });
        });

        // JavaScript to render the step chart
        document.addEventListener('DOMContentLoaded', function() {
            var ctxStep = document.getElementById('step-chart-example').getContext('2d');
            var myStepChart = new Chart(ctxStep, {
                type: 'line',
                data: {
                    // Labels for X-axis (Gender)
                    labels: ['Male', 'Female'],
                    datasets: [{
                        label: 'Average Resting Blood Pressure (trtbps)',
                        // Data for Y-axis (Resting Blood Pressure)
                        data: [<?php echo $avg_male[0]; ?>, <?php echo $avg_female[0]; ?>],
                        fill: false,
                        borderColor: 'rgba(114, 124, 245, 1)', // Color for the line
                        borderWidth: 2,
                        pointRadius: 0
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Gender'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Average Resting Blood Pressure (trtbps)'
                            }
                        }
                    }
                }
            });
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
