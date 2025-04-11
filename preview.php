<?php
session_start();
include_once("config.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['successMessage'] = "Please log in to access this page.";
    header("Location: login.php");
    exit();
}

// Get session variables
$username = $_SESSION['username'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    if(isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $target_dir = "images/users/";
        
        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Generate a unique filename to avoid overwriting
        $file_extension = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Move the uploaded file
        if(move_uploaded_file($_FILES['profileImage']['tmp_name'], $target_file)) {
            $_POST['image'] = $new_filename; // Update image field with new filename
        } else {
            $_POST['image'] = 'default-image.jpg'; // Use default if upload fails
        }
    } else {
        $_POST['image'] = 'default-image.jpg'; // Use default if no file uploaded
    }

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
    $template = mysqli_real_escape_string($conn, $_POST['template'] ?? '');
    preg_match('/\d+/', $template, $matches);
    $template = isset($matches[0]) ? $matches[0] : '1'; // Default to template 1 if not found


    // SQL statement - updated to match actual database structure
    // Note: Removed 'id' as it's likely auto-incremented
    $sql = "INSERT INTO cv_info (
        name, address, phone, email, birthday, gender, skill, companyname, 
        cstartdate, language, cposition, varsityname, cgpa, varsitypyear,
        collegename, hscgpa, clgpyear, schoolname, sscgpa, sclpyear, image, username, template
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Bind parameters - 22 parameters in correct order matching your table structure
        mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssssi', 
            $name, $address, $phone, $email, $birthday, $gender, $skill, $companyname,
            $cstartdate, $language, $cposition, $varsityname, $cgpa, $varsitypyear,
            $collegename, $hscgpa, $clgpyear, $schoolname, $sscgpa, $sclpyear, $image, $username, $template);

        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            $_SESSION['successMessage'] = "CV created successfully!";
            header("Location: index.php");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            $_SESSION['errorMessage'] = "Error creating CV: " . mysqli_stmt_error($stmt);
            header("Location: create_cv.php");
            exit();
        }
    } else {
        mysqli_close($conn);
        $_SESSION['errorMessage'] = "Error preparing statement: " . mysqli_error($conn);
        header("Location: create_cv.php");
        exit();
    }
} else {
    // Not a POST request
    header("Location: create_cv.php");
    exit();
}
?>