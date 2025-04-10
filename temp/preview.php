<?php
session_start();
include_once("config.php");

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Get session variables
$username = $_SESSION['username'];
$id = $_SESSION['id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch POST inputs
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $language = mysqli_real_escape_string($conn, $_POST['language'] ?? '');
    $skill = mysqli_real_escape_string($conn, $_POST['skill'] ?? '');
    $companyname = mysqli_real_escape_string($conn, $_POST['companyname'] ?? '');
    $cstartdate = mysqli_real_escape_string($conn, $_POST['cstartdate'] ?? '');
    $cposition = mysqli_real_escape_string($conn, $_POST['cposition'] ?? '');
    $varsityname = mysqli_real_escape_string($conn, $_POST['varsityname'] ?? '');
    $cgpa = mysqli_real_escape_string($conn, $_POST['cgpa'] ?? '');
    $varsitypyear = mysqli_real_escape_string($conn, $_POST['varsitypyear'] ?? '');
    $collegename = mysqli_real_escape_string($conn, $_POST['collegename'] ?? '');
    $hscgpa = mysqli_real_escape_string($conn, $_POST['hscgpa'] ?? '');
    $clgpyear = mysqli_real_escape_string($conn, $_POST['clgpyear'] ?? '');
    $schoolname = mysqli_real_escape_string($conn, $_POST['schoolname'] ?? '');
    $sscgpa = mysqli_real_escape_string($conn, $_POST['sscgpa'] ?? '');
    $sclpyear = mysqli_real_escape_string($conn, $_POST['sclpyear'] ?? '');
    $image = mysqli_real_escape_string($conn, $_POST['image'] ?? '');

    // Prepared statement (only 21 placeholders for POST data — id and username are inserted directly)
    $sql = "INSERT INTO cv_info (
        id, name, address, phone, email, birthday, gender, language, skill,
        companyname, cstartdate, cposition, varsityname, cgpa, varsitypyear,
        collegename, hscgpa, clgpyear, schoolname, sscgpa, sclpyear, image, username
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssss",
            $id, $name, $address, $phone, $email, $birthday, $gender, $language, $skill,
            $companyname, $cstartdate, $cposition, $varsityname, $cgpa, $varsitypyear,
            $collegename, $hscgpa, $clgpyear, $schoolname, $sscgpa, $sclpyear, $image, $username
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['successMessage'] = "Information inserted successfully!";
            header("Location: index.php");
            exit();
        } else {
            echo "Execute error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Prepare error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header("Location: create_cv.php");
    exit();
}
