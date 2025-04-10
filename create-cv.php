<link rel="stylesheet" href="css/create_cv.css">
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
    max-width: 1600px; /* Increased max-width */
    margin: 0 auto;
}

.form-container {
    width: 40%; /* Reduced form width */
    padding: 25px;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.preview-container {
    width: 60%; /* Increased preview width */
    padding: 25px;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow-x: hidden; /* Prevent horizontal scrolling */
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

/* Template 1 Preview Styles */
#template_1 #container {
    display: flex;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    min-height: 700px; /* Ensure consistent height */
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
    margin-bottom: 10px; /* Add space between contact elements */
    word-break: break-word; /* Allow long emails to wrap */
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
    max-width: 100%;
    background-color: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

#template_2 .cv-container {
    display: flex;
    min-height: 700px; /* Ensure consistent height */
}

#template_2 .sidebar {
    width: 38%; /* Slightly wider to accommodate content */
    background-color: #1e3a5f;
    color: white;
    padding: 30px 20px;
}

#template_2 .profile-image-placeholder {
    width: 130px;
    height: 130px;
    background-color: #ddd;
    border-radius: 50%;
    margin: 0 auto 20px;
}

#template_2 .full-name {
    font-size: 1.6rem;
    margin-bottom: 5px;
    text-align: center;
}

#template_2 .job-title {
    font-size: 1.1rem;
    font-weight: 300;
    margin-bottom: 25px;
    text-align: center;
}

#template_2 .contact-info {
    list-style: none;
    font-size: 0.95rem;
    margin-bottom: 25px;
    text-align: left;
    padding-left: 0;
}

#template_2 .contact-info li {
    margin-bottom: 10px;
    word-break: break-word; /* Allow long emails to wrap */
}

#template_2 .skills-section,
#template_2 .languages-section {
    margin-bottom: 25px;
}

#template_2 .skills-section h3,
#template_2 .languages-section h3 {
    font-size: 1.1rem;
    margin-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.5);
    text-align: left;
    padding-bottom: 5px;
}

#template_2 .main-content {
    display: block !important;
    flex: 1;
    padding: 40px;
    background-color: white;
}

#template_2 .section-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    padding: 25px 30px;
}

#template_2 .section-card h2 {
    color: #1e3a5f;
    margin-bottom: 20px;
    font-size: 1.5rem;
    text-align: left;
}

#template_2 .section-card .item {
    margin-bottom: 20px;
}

#template_2 .section-card .item h3 {
    font-size: 1.2rem;
    color: #0f2745;
}

#template_2 .section-card .item .date {
    font-size: 0.95rem;
    color: #555;
    display: block;
    margin: 5px 0 8px;
}

/* Template 3 Preview Styles */
#template_3 .wrapper {
    max-width: 100%;
    background-color: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

#template_3 .top-section {
    background: linear-gradient(135deg, #58b4ae, #a4d4ae);
    padding: 35px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 35px;
    border-bottom: 5px solid #53a3ff;
}

#template_3 .profile-image-placeholder {
    width: 150px;
    height: 150px;
    background-color: #ddd;
    border-radius: 50%;
    border: 4px solid #fff;
}

#template_3 .info {
    flex: 1;
    color: #fff;
    text-align: left;
    min-width: 280px; /* Ensure enough width for contact info */
}

#template_3 .info h1 {
    font-size: 2.3rem;
    margin-bottom: 8px;
    border: none;
}

#template_3 .info h3 {
    font-weight: 400;
    font-size: 1.3rem;
    margin-bottom: 15px;
}

#template_3 .contact-info p {
    margin-top: 12px;
    font-size: 1rem;
    color: #fff;
    line-height: 1.5;
    word-break: break-word; /* Allow long emails to wrap */
}

#template_3 .skills-languages {
    display: flex;
    gap: 35px;
    margin-top: 20px;
    flex-wrap: wrap; /* Allow wrapping on small screens */
}

#template_3 .skills-languages > div {
    flex: 1;
    min-width: 160px;
}

#template_3 .skills-languages h4 {
    font-size: 1.1rem;
    margin-bottom: 8px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.5);
    padding-bottom: 4px;
}

#template_3 .skills-languages p {
    font-size: 0.95rem;
}

#template_3 .main-content {
    display: block !important;
    padding: 35px;
}

#template_3 .section-card {
    background-color: #e7f1ff;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0, 80, 180, 0.1);
}

#template_3 .section-card h2 {
    font-size: 1.7rem;
    margin-bottom: 25px;
    color: #275778;
    border-left: 6px solid #53a3ff;
    padding-left: 15px;
    text-align: left;
}

#template_3 .item {
    margin-bottom: 25px;
}

#template_3 .item h3 {
    font-size: 1.3rem;
    color: #333;
}

#template_3 .date {
    font-size: 1rem;
    color: #555;
    margin: 8px 0;
    display: block;
}

/* Make template switching smooth */
.template-preview {
    display: none;
    transition: opacity 0.3s ease;
}

#template_1 {
    display: block; /* Show template 1 by default */
}

/* Responsive design for smaller screens */
@media (max-width: 992px) {
    .container {
        flex-direction: column;
        gap: 20px;
    }
    
    .form-container, .preview-container {
        width: 100%;
    }
    
    #template_1 #container, 
    #template_2 .cv-container {
        flex-direction: column;
    }
    
    #template_1 #left-div,
    #template_1 #right-div,
    #template_2 .sidebar {
        width: 100%;
    }
}
</style>
<div class="container">
    <!-- Left Side: Form -->
    <div class="form-container">
        
        <h2>Enter Your Details</h2>
        <form id="resumeForm" action="preview.php" method="POST" enctype="multipart/form-data">
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
</main>
<script src="js/create_cv.js"></script>

</body>
</html>