<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the database connection file
include_once("config.php");


if (!isset($_SESSION['username'])) {
    echo "You are not logged in. Please log in to access this page.";
    // header("Location: login.php");
    exit;
}

// Check if $conn is defined and valid
if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Error: Database connection is not properly initialized.");
}

// Check if connection is still open
if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if CV ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No CV ID provided.");
}

$cvId = mysqli_real_escape_string($conn, $_GET['id']);
$username = $_SESSION['username'];

// Check if this CV belongs to the logged-in user
$checkOwnership = "SELECT * FROM cv_info WHERE id = '$cvId' AND username = '$username'";
$ownershipResult = mysqli_query($conn, $checkOwnership);

if (!$ownershipResult || mysqli_num_rows($ownershipResult) === 0) {
    die("Error: You do not have permission to delete this CV or it doesn't exist.");
}

// Proceed to delete the CV
$deleteQuery = "DELETE FROM cv_info WHERE id = '$cvId'";
$deleteResult = mysqli_query($conn, $deleteQuery);

header("Location: ?page=demo");