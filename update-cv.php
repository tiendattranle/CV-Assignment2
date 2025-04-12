<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the database connection file

if (!isset($_SESSION['username'])) {
    echo "You are not logged in. Please log in to access this page.";
    header("Location: ?page=log-in");
    exit;
}

include_once("config.php");

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<link rel="stylesheet" href="css/edit-cv.css">
<style>
    <?php 
        $currentTemplate = $cvData['template'];
        echo "#template_1, #template_2, #template_3 { display: none; }\n";
        echo "#template_" . $currentTemplate . " { display: block; }\n";
    ?>
</style>
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
            
            <a href="?page=demo" class="back-btn">Cancel</a>
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