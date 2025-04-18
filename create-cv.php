<link rel="stylesheet" href="css/create_cv.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<?php
    // Check if form is submitted
    include_once("config.php");
    if (!isset($_SESSION['username'])) {
        $_SESSION['successMessage'] = "Please log in to access this page.";
        header("Location: ?page=log-in");
        exit();
    }
    $username = $_SESSION['username'];
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
                $_POST['image'] = 'default.jpg'; // Use default if upload fails
            }
        } else {
            $_POST['image'] = 'default.jpg'; // Use default if no file uploaded
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
    }

    $sql = "SELECT COUNT(*) as cv_count FROM cv_info WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cv_count = mysqli_fetch_assoc($result)['cv_count'];
    mysqli_stmt_close($stmt);
    
    // Check if user has reached CV limit
    if ($cv_count >= 3) {
        $_SESSION['errorMessage'] = "You have reached the limit of 3 CVs. Please delete or modify an existing CV to create a new one.";
        header("Location: index.php?page=my-cv");
        exit();
    }
?>
<div class="container">
    <!-- Left Side: Form -->
    <div class="form-container">
        
        <h2>Enter Your Details</h2>
        <form id="resumeForm" action="index.php?page=create-cv" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="templateSelector">Choose Template:</label>
                <select name="template" id="templateSelector" required>
                    <option value="template_1">Template 1</option>
                    <option value="template_2">Template 2</option>
                    <option value="template_3">Template 3</option>
                </select>
            </div>

            <div class="form-group">
                <label for="profileImage">Profile Image:</label>
                <input type="file" id="profileImage" name="profileImage" accept="image/*">
                <small>Select an image for your profile (Optional)</small>
            </div>

            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="language">Languages:</label>
                <textarea id="language" name="language" placeholder="Enter languages you speak (e.g., English, Spanish)" required></textarea>
            </div>

            <div class="form-group">
                <label for="skill">Skills:</label>
                <textarea id="skill" name="skill" placeholder="Enter your skills (e.g., Programming, Project Management)" required></textarea>
            </div>

            <div class="section-header">
                <h3>Work Experience</h3>
            </div>

            <div class="form-group">
                <label for="companyname">Company Name:</label>
                <input type="text" id="companyname" name="companyname">
            </div>

            <div class="form-group">
                <label for="cstartdate">Start Date:</label>
                <input type="date" id="cstartdate" name="cstartdate">
            </div>

            <div class="form-group">
                <label for="cposition">Position:</label>
                <input type="text" id="cposition" name="cposition">
            </div>

            <div class="section-header">
                <h3>Education</h3>
            </div>

            <div class="form-group">
                <label for="varsityname">University:</label>
                <input type="text" id="varsityname" name="varsityname">
            </div>

            <div class="form-group">
                <label for="cgpa">CGPA:</label>
                <input type="text" id="cgpa" name="cgpa">
            </div>

            <div class="form-group">
                <label for="varsitypyear">Passing Year:</label>
                <input type="text" id="varsitypyear" name="varsitypyear">
            </div>

            <div class="form-group">
                <label for="collegename">College:</label>
                <input type="text" id="collegename" name="collegename">
            </div>

            <div class="form-group">
                <label for="hscgpa">HSC GPA:</label>
                <input type="text" id="hscgpa" name="hscgpa">
            </div>

            <div class="form-group">
                <label for="clgpyear">Passing Year:</label>
                <input type="text" id="clgpyear" name="clgpyear">
            </div>

            <div class="form-group">
                <label for="schoolname">School:</label>
                <input type="text" id="schoolname" name="schoolname">
            </div>

            <div class="form-group">
                <label for="sscgpa">SSC GPA:</label>
                <input type="text" id="sscgpa" name="sscgpa">
            </div>

            <div class="form-group">
                <label for="sclpyear">Passing Year:</label>
                <input type="text" id="sclpyear" name="sclpyear">
            </div>

            <!-- Hidden field for image path -->
            <input type="hidden" name="image" id="image" value="default-image.jpg">

            <div class="form-group">
                <button type="submit" class="submit-btn">Create Resume</button>
            </div>
        </form>
    </div>

    <!-- Right Side: Resume Preview -->
    <div class="preview-container">
        <!-- Template 1 Preview (matches template1.php) -->
        <div class="template-preview" id="template_1">
            <div id="container">
                <div id="left-div">
                    <div class="profile-image-placeholder"></div>
                    <div id="left-middle-div">
                        <h2 class="name" id="previewName">Your Name</h2>
                        <p><i class="bx bx-home left-logo" id="home-logo"></i> <span id="previewAddress">Your address</span></p>
                        <p><i class="bx bx-phone left-logo" id="phone-logo"></i> <span id="previewPhone">123-456-7890</span></p>
                        <p><i class="bx bx-envelope left-logo" id="email-logo"></i> <span id="previewEmail">your.email@example.com</span></p>
                    </div><br>
        
                    <div id="left-bottom-div">
                        <h2 class="skills"><i class="bx bx-bulb left-logo" id="skills-logo"></i> Skills</h2>
                        <p id="previewSkill" class="skills-dtl">Your skills</p>
                    </div>
        
                    <div id="left-bottom-languages-div">
                        <h2 class="skills"><i class="bx bx-book left-logo" id="language-logo"></i> Languages</h2>
                        <p id="previewLanguage" class="skills-dtl">Your languages</p>
                    </div>
                </div>
        
                <div id="right-div">
                    <div id="right-top-div">
                        <h1><i class="bx bx-briefcase right-logo" id="work-logo"></i> Work Experience</h1>
                        <h2 id="previewCompanyname" class="name-institute">Company Name</h2>
                        <h5 id="previewCposition" class="description">Position</h5>
                        <p id="previewCstartdate" class="description">Start Date</p>
                    </div><br>
        
                    <div id="right-bottom-div">
                        <h1><i class="bx bxs-graduation right-logo" id="edu-logo"></i> Education</h1>
        
                        <div id="varsity-div">
                            <h2 id="previewVarsityname" class="name-institute">Your University</h2>
                            <h4 class="description">CGPA: <span id="previewCgpa">CGPA</span></h4>
                            <h5 class="description">Graduated: <span id="previewVarsitypyear">Year</span></h5>
                        </div><br>
        
                        <div id="college-div">
                            <h2 id="previewCollegename" class="name-institute">Your College</h2>
                            <h4 class="description">GPA: <span id="previewHscgpa">HSC GPA</span></h4>
                            <h5 class="description">Graduated: <span id="previewClgpyear">Year</span></h5>
                        </div><br>
        
                        <div id="school-div">
                            <h2 id="previewSchoolname" class="name-institute">Your School</h2>
                            <h4 class="description">GPA: <span id="previewSscgpa">SSC GPA</span></h4>
                            <h5 class="description">Graduated: <span id="previewSclpyear">Year</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template 2 Preview (matches template2.php) -->
        <div class="template-preview" id="template_2" style="display:none;">
            <div class="wrapper">
                <div class="cv-container">
                    <aside class="sidebar">
                        <div class="profile-pic">
                            <div class="profile-image-placeholder"></div>
                        </div>
                        <h2 class="full-name" id="previewName">Your Name</h2>
                        <p class="job-title" id="previewCposition">Position</p>
                        <ul class="contact-info">
                            <li><strong>Address:</strong> <span id="previewAddress">Your address</span></li>
                            <li><strong>Phone:</strong> <span id="previewPhone">123-456-7890</span></li>
                            <li><strong>Email:</strong> <span id="previewEmail">your.email@example.com</span></li>
                        </ul>

                        <div class="skills-section">
                            <h3>Tech Stack</h3>
                            <p id="previewSkill">Your skills</p>
                        </div>
                        <div class="languages-section">
                            <h3>Languages</h3>
                            <p id="previewLanguage">Your languages</p>
                        </div>
                    </aside>

                    <main class="main-content">
                        <section class="section-card">
                            <h2>Work History</h2>
                            <div class="item">
                                <h3><span id="previewCposition">Position</span> - <span id="previewCompanyname">Company Name</span></h3>
                                <span class="date" id="previewCstartdate">Start Date</span>
                            </div>
                        </section>

                        <section class="section-card">
                            <h2>Education</h2>

                            <div class="item">
                                <h3 id="previewVarsityname">Your University</h3>
                                <span class="date">Graduated: <span id="previewVarsitypyear">Year</span></span>
                                <p>CGPA: <span id="previewCgpa">CGPA</span></p>
                            </div>

                            <div class="item">
                                <h3 id="previewCollegename">Your College</h3>
                                <span class="date">Graduated: <span id="previewClgpyear">Year</span></span>
                                <p>GPA: <span id="previewHscgpa">HSC GPA</span></p>
                            </div>

                            <div class="item">
                                <h3 id="previewSchoolname">Your School</h3>
                                <span class="date">Graduated: <span id="previewSclpyear">Year</span></span>
                                <p>GPA: <span id="previewSscgpa">SSC GPA</span></p>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>

        <!-- Template 3 Preview (matches template3.php) -->
        <div class="template-preview" id="template_3" style="display:none;">
            <div class="wrapper">
                <!-- Top Header Section -->
                <header class="top-section">
                    <div class="profile-pic">
                        <div class="profile-image-placeholder"></div>
                    </div>
                    <div class="info">
                        <h1 id="previewName">Your Name</h1>
                        <h3 id="previewCposition">Position</h3>

                        <div class="contact-info">
                            <p><strong>📍</strong> <span id="previewAddress">Your address</span></p>
                            <p><strong>📞</strong> <span id="previewPhone">123-456-7890</span></p>
                            <p><strong>✉️</strong> <span id="previewEmail">your.email@example.com</span></p>
                        </div>

                        <div class="skills-languages">
                            <div>
                                <h4>Tech Stack</h4>
                                <p id="previewSkill">Your skills</p>
                            </div>
                            <div>
                                <h4>Languages</h4>
                                <p id="previewLanguage">Your languages</p>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="main-content">
                    <section class="section-card">
                        <h2>Work Experience</h2>
                        <div class="item">
                            <h3><span id="previewCposition">Position</span> - <span id="previewCompanyname">Company Name</span></h3>
                            <span class="date" id="previewCstartdate">Start Date</span>
                        </div>
                    </section>

                    <section class="section-card">
                        <h2>Education</h2>

                        <div class="item">
                            <h3 id="previewVarsityname">Your University</h3>
                            <span class="date">Graduated: <span id="previewVarsitypyear">Year</span></span>
                            <p>CGPA: <span id="previewCgpa">CGPA</span></p>
                        </div>

                        <div class="item">
                            <h3 id="previewCollegename">Your College</h3>
                            <span class="date">Graduated: <span id="previewClgpyear">Year</span></span>
                            <p>GPA: <span id="previewHscgpa">HSC GPA</span></p>
                        </div>

                        <div class="item">
                            <h3 id="previewSchoolname">Your School</h3>
                            <span class="date">Graduated: <span id="previewSclpyear">Year</span></span>
                            <p>GPA: <span id="previewSscgpa">SSC GPA</span></p>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
</div>
<script src="js/create_cv.js"></script>
