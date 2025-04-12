<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
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
    die("Error: You do not have permission to edit this CV or it doesn't exist.");
}

// Fetch CV data
$cvData = mysqli_fetch_assoc($ownershipResult);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $skill = mysqli_real_escape_string($conn, $_POST['skill']);
    $companyname = mysqli_real_escape_string($conn, $_POST['companyname']);
    $cstartdate = mysqli_real_escape_string($conn, $_POST['cstartdate']);
    $cposition = mysqli_real_escape_string($conn, $_POST['cposition']);
    $varsityname = mysqli_real_escape_string($conn, $_POST['varsityname']);
    $cgpa = mysqli_real_escape_string($conn, $_POST['cgpa']);
    $varsitypyear = mysqli_real_escape_string($conn, $_POST['varsitypyear']);
    $collegename = mysqli_real_escape_string($conn, $_POST['collegename']);
    $hscgpa = mysqli_real_escape_string($conn, $_POST['hscgpa']);
    $clgpyear = mysqli_real_escape_string($conn, $_POST['clgpyear']);
    $schoolname = mysqli_real_escape_string($conn, $_POST['schoolname']);
    $sscgpa = mysqli_real_escape_string($conn, $_POST['sscgpa']);
    $sclpyear = mysqli_real_escape_string($conn, $_POST['sclpyear']);
    
    // Convert template_X to just the number
    $template = mysqli_real_escape_string($conn, $_POST['template']);
    if (strpos($template, 'template_') === 0) {
        $template = substr($template, -1);
    }

    // Handle image upload
    $image = $cvData['image']; // Default to current image name (not full path)
        
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/users/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $targetFilePath = $uploadDir . $new_filename;
        
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFilePath)) {
            $image = $new_filename; // Store only the filename, not the full path
        } else {
            echo "Error uploading image: " . error_get_last()['message'];
        }
    }


    // Update CV in database
    $updateQuery = "UPDATE cv_info SET 
        name = '$name', 
        address = '$address', 
        phone = '$phone', 
        email = '$email', 
        birthday = '$birthday', 
        gender = '$gender', 
        language = '$language', 
        skill = '$skill', 
        companyname = '$companyname', 
        cstartdate = '$cstartdate', 
        cposition = '$cposition', 
        varsityname = '$varsityname', 
        cgpa = '$cgpa', 
        varsitypyear = '$varsitypyear', 
        collegename = '$collegename', 
        hscgpa = '$hscgpa', 
        clgpyear = '$clgpyear', 
        schoolname = '$schoolname', 
        sscgpa = '$sscgpa', 
        sclpyear = '$sclpyear', 
        template = '$template'";
    
    // Update the update query part (around line 120-126):
    // Only update image if a new one was uploaded
    if ($image !== $cvData['image']) {
        $updateQuery .= ", image = '$image'";
    }

    
    $updateQuery .= " WHERE id = '$cvId' AND username = '$username'";
    
    $updateResult = mysqli_query($conn, $updateQuery);
    
    if ($updateResult) {
        // Redirect to demo page after successful update
        header("Location: demo.php");
        exit;
    } else {
        echo "Error updating CV: " . mysqli_error($conn);
    }

    
    
}

// Helper function for template dropdown
function getSelectedAttribute($value, $selectedValue) {
    return ($value === $selectedValue) ? 'selected' : '';
}
function getImagePath($image) {
    $image_path = 'images/users/';
    // return $image;
    if (!empty($image) && file_exists($image_path.$image)) {
        return $image_path.$image;
    }
    return $image_path.'default.jpg'; // Path to your default image
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit CV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            display: flex;
            width: 100%;
            gap: 30px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .form-container {
            width: 40%;
            padding: 25px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .preview-container {
            width: 60%;
            padding: 25px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow-x: hidden;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #555;
        }

        form#resumeForm textarea, 
        form#resumeForm input, 
        form#resumeForm select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s;
            margin:auto;
        }

        textarea:focus, input:focus, select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        .section-header h3 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin: 25px 0 15px;
            color: #2c3e50;
            font-weight: 600;
        }

        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 25px;
            width: 100%;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .back-btn {
            background-color: #95a5a6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 10px;
            width: 100%;
            font-size: 16px;
            text-align: center;
            display: block;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #7f8c8d;
        }

        /* Template styles (copied from create-cv.php) */
        /* Template 1 Preview Styles */
        #template_1 #container {
            display: flex;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            min-height: 700px;
        }

        #template_1 #left-div {
            width: 35%;
            background-color: #ecf0f1;
            padding: 25px 20px;
            text-align: center;
        }

        #template_1 .profile-image-placeholder {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background-color: #ddd;
            margin: 0 auto 25px;
        }

        #template_1 #left-middle-div, 
        #template_1 #left-bottom-div, 
        #template_1 #left-bottom-languages-div {
            margin-top: 25px;
            text-align: left;
        }

        #template_1 #left-middle-div h2, 
        #template_1 #left-bottom-div h2, 
        #template_1 #left-bottom-languages-div h2 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 12px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
            text-align: left;
        }

        #template_1 .left-logo, 
        #template_1 #email-logo, 
        #template_1 #skills-logo, 
        #template_1 #language-logo {
            width: 16px;
            height: 16px;
            vertical-align: middle;
            margin-right: 8px;
        }

        #template_1 #left-middle-div p {
            margin-bottom: 10px;
            word-break: break-word;
        }

        #template_1 #right-div {
            width: 65%;
            padding: 30px;
            background-color: white;
        }

        #template_1 #right-div h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 2px solid #1abc9c;
            padding-bottom: 8px;
        }

        #template_1 .name-institute {
            font-size: 20px;
            font-weight: bold;
            color: #34495e;
        }

        #template_1 .description {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        #template_1 .right-logo {
            width: 24px;
            height: 24px;
            vertical-align: middle;
            margin-right: 10px;
        }

        /* Template 2 Preview Styles */
        #template_2 .wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        #template_2 .cv-container {
            display: flex;
            min-height: 700px;
        }
        
        #template_2 .sidebar {
            width: 35%;
            background-color: #2c3e50;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        #template_2 .profile-image-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #ddd;
            margin: 0 auto 25px;
            border: 5px solid rgba(255, 255, 255, 0.3);
        }
        
        #template_2 .full-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            color: white;
        }
        
        #template_2 .job-title {
            font-size: 16px;
            color: #ecf0f1;
            margin-bottom: 25px;
            font-style: italic;
        }
        
        #template_2 .contact-info {
            list-style: none;
            padding: 0;
            margin: 0 0 25px;
            text-align: left;
        }
        
        #template_2 .contact-info li {
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        #template_2 .skills-section,
        #template_2 .languages-section {
            margin-top: 25px;
            text-align: left;
        }
        
        #template_2 .skills-section h3,
        #template_2 .languages-section h3 {
            font-size: 18px;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        
        #template_2 .main-content {
            width: 65%;
            padding: 30px;
            background-color: white;
        }
        
        #template_2 .section-card {
            margin-bottom: 30px;
        }
        
        #template_2 .section-card h2 {
            font-size: 22px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        
        #template_2 .section-card .item {
            margin-bottom: 20px;
        }
        
        #template_2 .section-card .item h3 {
            font-size: 18px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 5px;
        }
        
        #template_2 .section-card .item .date {
            display: block;
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        
        /* Template 3 Preview Styles */
        #template_3 .wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        #template_3 .top-section {
            background: linear-gradient(135deg, #4a6572 0%, #2c3e50 100%);
            color: white;
            padding: 30px;
            display: flex;
            align-items: center;
        }
        
        #template_3 .profile-image-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: 25px;
            border: 4px solid rgba(255, 255, 255, 0.2);
        }
        
        #template_3 .info {
            flex-grow: 1;
        }
        
        #template_3 .info h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: white;
        }
        
        #template_3 .info h3 {
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: normal;
            color: #ecf0f1;
        }
        
        #template_3 .contact-info p {
            margin-bottom: 5px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        #template_3 .skills-languages {
            margin-top: 15px;
            display: flex;
            gap: 20px;
        }
        
        #template_3 .skills-languages > div {
            flex: 1;
        }
        
        #template_3 .skills-languages h4 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #ecf0f1;
        }
        
        #template_3 .skills-languages p {
            font-size: 14px;
            color: #ecf0f1;
        }
        
        #template_3 .main-content {
            padding: 30px;
        }
        
        #template_3 .section-card {
            margin-bottom: 25px;
        }
        
        #template_3 .section-card h2 {
            font-size: 20px;
            color: #2c3e50;
            border-left: 4px solid #3498db;
            padding-left: 10px;
            margin-bottom: 15px;
        }
        
        #template_3 .item {
            margin-bottom: 20px;
            padding-left: 15px;
            border-left: 1px dashed #ddd;
        }
        
        #template_3 .item h3 {
            font-size: 18px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 5px;
        }
        
        #template_3 .date {
            display: block;
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        /* Template switching */
        .template-preview {
            transition: opacity 0.3s ease;
        }

        /* Initial display for correct template */
        <?php 
            $currentTemplate = $cvData['template'];
            echo "#template_1, #template_2, #template_3 { display: none; }\n";
            echo "#template_" . $currentTemplate . " { display: block; }\n";
        ?>

        /* Mobile responsive styles */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
                gap: 20px;
            }
            
            .form-container, .preview-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Side: Form -->
        <div class="form-container">
            <h2>Edit Your CV</h2>
            <form id="resumeForm" action="edit_cv.php?id=<?php echo $cvId; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="templateSelector">Choose Template:</label>
                    <select name="template" id="templateSelector" required>
                        <option value="template_1" <?php echo ($cvData['template'] === '1') ? 'selected' : ''; ?>>Template 1</option>
                        <option value="template_2" <?php echo ($cvData['template'] === '2') ? 'selected' : ''; ?>>Template 2</option>
                        <option value="template_3" <?php echo ($cvData['template'] === '3') ? 'selected' : ''; ?>>Template 3</option>
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="profileImage">Profile Image:</label>
                    <input type="file" id="profileImage" name="profileImage" accept="image/*">
                    <small>Select a new image (leave empty to keep current image)</small>
                    <?php if(!empty($cvData['image'])): ?>
                        <p><small>Current image: <?php echo basename($cvData['image']); ?></small></p>
                    <?php endif; ?>
                </div>
        
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($cvData['name']); ?>" required>
                </div>
        
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($cvData['address']); ?>" required>
                </div>
        
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($cvData['phone']); ?>" required>
                </div>
        
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cvData['email']); ?>" required>
                </div>
        
                <div class="form-group">
                    <label for="birthday">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($cvData['birthday']); ?>" required>
                </div>
        
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php echo ($cvData['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($cvData['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="language">Languages:</label>
                    <textarea id="language" name="language" required><?php echo htmlspecialchars($cvData['language']); ?></textarea>
                </div>
        
                <div class="form-group">
                    <label for="skill">Skills:</label>
                    <textarea id="skill" name="skill" required><?php echo htmlspecialchars($cvData['skill']); ?></textarea>
                </div>
        
                <div class="section-header">
                    <h3>Work Experience</h3>
                </div>
        
                <div class="form-group">
                    <label for="companyname">Company Name:</label>
                    <input type="text" id="companyname" name="companyname" value="<?php echo htmlspecialchars($cvData['companyname']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="cposition">Position:</label>
                    <input type="text" id="cposition" name="cposition" value="<?php echo htmlspecialchars($cvData['cposition']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="cstartdate">Start Date:</label>
                    <input type="date" id="cstartdate" name="cstartdate" value="<?php echo htmlspecialchars($cvData['cstartdate']); ?>">
                </div>
        
                <div class="section-header">
                    <h3>Education</h3>
                </div>
        
                <div class="form-group">
                    <label for="varsityname">University:</label>
                    <input type="text" id="varsityname" name="varsityname" value="<?php echo htmlspecialchars($cvData['varsityname']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="cgpa">CGPA:</label>
                    <input type="text" id="cgpa" name="cgpa" value="<?php echo htmlspecialchars($cvData['cgpa']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="varsitypyear">Passing Year:</label>
                    <input type="text" id="varsitypyear" name="varsitypyear" value="<?php echo htmlspecialchars($cvData['varsitypyear']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="collegename">College:</label>
                    <input type="text" id="collegename" name="collegename" value="<?php echo htmlspecialchars($cvData['collegename']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="hscgpa">HSC GPA:</label>
                    <input type="text" id="hscgpa" name="hscgpa" value="<?php echo htmlspecialchars($cvData['hscgpa']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="clgpyear">Passing Year:</label>
                    <input type="text" id="clgpyear" name="clgpyear" value="<?php echo htmlspecialchars($cvData['clgpyear']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="schoolname">School:</label>
                    <input type="text" id="schoolname" name="schoolname" value="<?php echo htmlspecialchars($cvData['schoolname']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="sscgpa">SSC GPA:</label>
                    <input type="text" id="sscgpa" name="sscgpa" value="<?php echo htmlspecialchars($cvData['sscgpa']); ?>">
                </div>
        
                <div class="form-group">
                    <label for="sclpyear">Passing Year:</label>
                    <input type="text" id="sclpyear" name="sclpyear" value="<?php echo htmlspecialchars($cvData['sclpyear']); ?>">
                </div>
        
                <div class="form-group">
                    <button type="submit" class="submit-btn">Save Changes</button>
                </div>
                
                <a href="demo.php" class="back-btn">Cancel</a>
            </form>
        </div>
    
        <!-- Right Side: Preview -->
        <div class="preview-container">
            <!-- Template 1 Preview -->
            <div class="template-preview" id="template_1">
                <div id="container">
                    <div id="left-div">
                        <div class="profile-image-placeholder" style="<?php echo !empty($cvData['image']) ? 'background-image: url(' . htmlspecialchars(getImagePath($cvData['image'])) . '); background-size: cover; background-position: center;' : ''; ?>"></div>
                        <div id="left-middle-div">
                            <h2 class="name" id="previewName"><?php echo htmlspecialchars($cvData['name']); ?></h2>
                            <p><i class="bx bx-home left-logo" id="home-logo"></i> <span id="previewAddress"><?php echo htmlspecialchars($cvData['address']); ?></span></p>
                            <p><i class="bx bx-phone left-logo" id="phone-logo"></i> <span id="previewPhone"><?php echo htmlspecialchars($cvData['phone']); ?></span></p>
                            <p><i class="bx bx-envelope left-logo" id="email-logo"></i> <span id="previewEmail"><?php echo htmlspecialchars($cvData['email']); ?></span></p>
                        </div><br>
            
                        <div id="left-bottom-div">
                            <h2 class="skills"><i class="bx bx-bulb left-logo" id="skills-logo"></i> Skills</h2>
                            <p id="previewSkill" class="skills-dtl"><?php echo htmlspecialchars($cvData['skill']); ?></p>
                        </div>
            
                        <div id="left-bottom-languages-div">
                            <h2 class="skills"><i class="bx bx-book left-logo" id="language-logo"></i> Languages</h2>
                            <p id="previewLanguage" class="skills-dtl"><?php echo htmlspecialchars($cvData['language']); ?></p>
                        </div>
                    </div>
            
                    <div id="right-div">
                        <div id="right-top-div">
                            <h1><i class="bx bx-briefcase right-logo" id="work-logo"></i> Work Experience</h1>
                            <h2 id="previewCompanyname" class="name-institute"><?php echo htmlspecialchars($cvData['companyname']); ?></h2>
                            <h5 id="previewCposition" class="description"><?php echo htmlspecialchars($cvData['cposition']); ?></h5>
                            <p id="previewCstartdate" class="description"><?php echo htmlspecialchars($cvData['cstartdate']); ?></p>
                        </div><br>
            
                        <div id="right-bottom-div">
                            <h1><i class="bx bxs-graduation right-logo" id="edu-logo"></i> Education</h1>
            
                            <div id="varsity-div">
                                <h2 id="previewVarsityname" class="name-institute"><?php echo htmlspecialchars($cvData['varsityname']); ?></h2>
                                <h4 class="description">CGPA: <span id="previewCgpa"><?php echo htmlspecialchars($cvData['cgpa']); ?></span></h4>
                                <h5 class="description">Graduated: <span id="previewVarsitypyear"><?php echo htmlspecialchars($cvData['varsitypyear']); ?></span></h5>
                            </div><br>
            
                            <div id="college-div">
                                <h2 id="previewCollegename" class="name-institute"><?php echo htmlspecialchars($cvData['collegename']); ?></h2>
                                <h4 class="description">GPA: <span id="previewHscgpa"><?php echo htmlspecialchars($cvData['hscgpa']); ?></span></h4>
                                <h5 class="description">Graduated: <span id="previewClgpyear"><?php echo htmlspecialchars($cvData['clgpyear']); ?></span></h5>
                            </div><br>
            
                            <div id="school-div">
                                <h2 id="previewSchoolname" class="name-institute"><?php echo htmlspecialchars($cvData['schoolname']); ?></h2>
                                <h4 class="description">GPA: <span id="previewSscgpa"><?php echo htmlspecialchars($cvData['sscgpa']); ?></span></h4>
                                <h5 class="description">Graduated: <span id="previewSclpyear"><?php echo htmlspecialchars($cvData['sclpyear']); ?></span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Template 2 Preview -->
            <div class="template-preview" id="template_2">
                <div class="wrapper">
                    <div class="cv-container">
                        <aside class="sidebar">
                            <div class="profile-pic">
                                <div class="profile-image-placeholder" style="<?php echo !empty($cvData['image']) ? 'background-image: url(' . htmlspecialchars(getImagePath($cvData['image'])) . '); background-size: cover; background-position: center;' : ''; ?>"></div>
                            </div>
                            <h2 class="full-name" id="previewName"><?php echo htmlspecialchars($cvData['name']); ?></h2>
                            <p class="job-title" id="previewCposition"><?php echo htmlspecialchars($cvData['cposition']); ?></p>
                            <ul class="contact-info">
                                <li><strong>Address:</strong> <span id="previewAddress"><?php echo htmlspecialchars($cvData['address']); ?></span></li>
                                <li><strong>Phone:</strong> <span id="previewPhone"><?php echo htmlspecialchars($cvData['phone']); ?></span></li>
                                <li><strong>Email:</strong> <span id="previewEmail"><?php echo htmlspecialchars($cvData['email']); ?></span></li>
                            </ul>
                            <div class="skills-section">
                                <h3>Tech Stack</h3>
                                <p id="previewSkill"><?php echo htmlspecialchars($cvData['skill']); ?></p>
                            </div>
                            <div class="languages-section">
                                <h3>Languages</h3>
                                <p id="previewLanguage"><?php echo htmlspecialchars($cvData['language']); ?></p>
                            </div>
                        </aside>
                        <main class="main-content">
                            <section class="section-card">
                                <h2>Work History</h2>
                                <div class="item">
                                    <h3><span id="previewCposition"><?php echo htmlspecialchars($cvData['cposition']); ?></span> - <span id="previewCompanyname"><?php echo htmlspecialchars($cvData['companyname']); ?></span></h3>
                                    <span class="date" id="previewCstartdate"><?php echo htmlspecialchars($cvData['cstartdate']); ?></span>
                                </div>
                            </section>
                            <section class="section-card">
                                <h2>Education</h2>
                                <div class="item">
                                    <h3 id="previewVarsityname"><?php echo htmlspecialchars($cvData['varsityname']); ?></h3>
                                    <span class="date">Graduated: <span id="previewVarsitypyear"><?php echo htmlspecialchars($cvData['varsitypyear']); ?></span></span>
                                    <p>CGPA: <span id="previewCgpa"><?php echo htmlspecialchars($cvData['cgpa']); ?></span></p>
                                </div>
                                <div class="item">
                                    <h3 id="previewCollegename"><?php echo htmlspecialchars($cvData['collegename']); ?></h3>
                                    <span class="date">Graduated: <span id="previewClgpyear"><?php echo htmlspecialchars($cvData['clgpyear']); ?></span></span>
                                    <p>GPA: <span id="previewHscgpa"><?php echo htmlspecialchars($cvData['hscgpa']); ?></span></p>
                                </div>
                                <div class="item">
                                    <h3 id="previewSchoolname"><?php echo htmlspecialchars($cvData['schoolname']); ?></h3>
                                    <span class="date">Graduated: <span id="previewSclpyear"><?php echo htmlspecialchars($cvData['sclpyear']); ?></span></span>
                                    <p>GPA: <span id="previewSscgpa"><?php echo htmlspecialchars($cvData['sscgpa']); ?></span></p>
                                </div>
                            </section>
                        </main>
                    </div>
                </div>
            </div>
    
            <!-- Template 3 Preview -->
            <div class="template-preview" id="template_3">
                <div class="wrapper">
                    <header class="top-section">
                        <div class="profile-pic">
                            <div class="profile-image-placeholder" style="<?php echo !empty($cvData['image']) ? 'background-image: url(' . htmlspecialchars(getImagePath($cvData['image'])) . '); background-size: cover; background-position: center;' : ''; ?>"></div>
                        </div>
                        <div class="info">
                            <h1 id="previewName"><?php echo htmlspecialchars($cvData['name']); ?></h1>
                            <h3 id="previewCposition"><?php echo htmlspecialchars($cvData['cposition']); ?></h3>
                            <div class="contact-info">
                                <p><strong>📍</strong> <span id="previewAddress"><?php echo htmlspecialchars($cvData['address']); ?></span></p>
                                <p><strong>📞</strong> <span id="previewPhone"><?php echo htmlspecialchars($cvData['phone']); ?></span></p>
                                <p><strong>✉️</strong> <span id="previewEmail"><?php echo htmlspecialchars($cvData['email']); ?></span></p>
                            </div>
                            <div class="skills-languages">
                                <div>
                                    <h4>Tech Stack</h4>
                                    <p id="previewSkill"><?php echo htmlspecialchars($cvData['skill']); ?></p>
                                </div>
                                <div>
                                    <h4>Languages</h4>
                                    <p id="previewLanguage"><?php echo htmlspecialchars($cvData['language']); ?></p>
                                </div>
                            </div>
                        </div>
                    </header>
                    <main class="main-content">
                        <section class="section-card">
                            <h2>Work Experience</h2>
                            <div class="item">
                                <h3><span id="previewCposition"><?php echo htmlspecialchars($cvData['cposition']); ?></span> - <span id="previewCompanyname"><?php echo htmlspecialchars($cvData['companyname']); ?></span></h3>
                                <span class="date" id="previewCstartdate"><?php echo htmlspecialchars($cvData['cstartdate']); ?></span>
                            </div>
                        </section>
                        <section class="section-card">
                            <h2>Education</h2>
                            <div class="item">
                                <h3 id="previewVarsityname"><?php echo htmlspecialchars($cvData['varsityname']); ?></h3>
                                <span class="date">Graduated: <span id="previewVarsitypyear"><?php echo htmlspecialchars($cvData['varsitypyear']); ?></span></span>
                                <p>CGPA: <span id="previewCgpa"><?php echo htmlspecialchars($cvData['cgpa']); ?></span></p>
                            </div>
                            <div class="item">
                                <h3 id="previewCollegename"><?php echo htmlspecialchars($cvData['collegename']); ?></h3>
                                <span class="date">Graduated: <span id="previewClgpyear"><?php echo htmlspecialchars($cvData['clgpyear']); ?></span></span>
                                <p>GPA: <span id="previewHscgpa"><?php echo htmlspecialchars($cvData['hscgpa']); ?></span></p>
                            </div>
                            <div class="item">
                                <h3 id="previewSchoolname"><?php echo htmlspecialchars($cvData['schoolname']); ?></h3>
                                <span class="date">Graduated: <span id="previewSclpyear"><?php echo htmlspecialchars($cvData['sclpyear']); ?></span></span>
                                <p>GPA: <span id="previewSscgpa"><?php echo htmlspecialchars($cvData['sscgpa']); ?></span></p>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the JavaScript file -->
    <script src="js/create_cv.js"></script>
</body>
</html>