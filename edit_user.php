<?php
include 'connection.php';

// If it's a POST request, handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $username = $_POST['username'];
    $type = $_POST['type'];
    
    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE user SET lname=?, fname=?, mname=?, username=?, type=? WHERE user_id=?");
    $stmt->bind_param("sssssi", $lname, $fname, $mname, $username, $type, $id);
    $stmt->execute();
    
    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect back to manageUser.php
        header("location: userManagement.php");
        exit; // End script execution after redirection
    } else {
        // Handle update failure (optional)
        // You can display an error message or log the error
        echo "Error updating user. Please try again.";
    }
}

// If it's a GET request, check if an 'id' parameter is provided
if (!isset($_GET['id'])) {
    // Redirect if 'id' parameter is not provided
    header("location: userManagement.php");
    exit;
}

$id = $_GET['id'];

// Fetch user data based on the provided id
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Redirect if no user found with the provided id
    header("location: userManagement.php");
    exit;
}

$row = $result->fetch_assoc();

// Extract user data for editing
$lname = $row["lname"];
$fname = $row["fname"];
$mname = $row["mname"];
$username = $row["username"];
$type = $row["type"];
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Edit User</title>
    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 50px;
        }
    </style>

</head>
<body class="loading authentication-bg" >

<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
    <div class="row justify-content-center">
    <div class="col-xxl-4 col-lg-5">
    <div class="card">

        <div class="card-header pt-4 pb-4 text-center bg-primary">
            <a href="index.html">
                <span><img src="assets/images/logo.png" alt="" height="18"></span>
            </a>
        </div>

        <div class="card-body p-4">

            <div class="text-center w-75 m-auto">
                <h4 class="text-dark-50 text-center pb-0 fw-bold">Update User</h4>
            </div>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label class="form-label">LastName</label>
                <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">FirstName</label>
                <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">MiddleName</label>
                <input type="text" class="form-control" name="mname" value="<?php echo $mname; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" class="form-control" name="type" value="<?php echo $type; ?>">
            </div>
            <div class="row mb-3">
                <div class="col-6">
                <button type="submit" class="btn btn-primary rounded-pill">Submit</button>
                </div>
                <div class="col-6">
                    <a href="userManagement.php" role="button"><button type="button" class="btn btn-info rounded-pill">Cancel</button></a>
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
