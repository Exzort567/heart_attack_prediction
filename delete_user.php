<?php
include('connection.php');

// Check if the request method is POST and the 'id' parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // If deletion is successful, redirect back to manageUser.php
        header("location: userManagement.php");
        exit;
    } else {
        // If deletion fails, display an error message
        echo "Error deleting user: " . $stmt->error;
    }
} else {
    // If 'id' parameter is not set or request method is not POST, redirect to manageUser.php
    header("location: userManagement.php");
    exit;
}
?>
