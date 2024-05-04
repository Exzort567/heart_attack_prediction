<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('connection.php');

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>
