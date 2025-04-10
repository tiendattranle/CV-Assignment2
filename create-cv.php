<style>
    .container {
        font-family: Arial, sans-serif;
        display: flex;
        width: 100%;
    }
    .form-container, .preview-container {
        width: 50%;
        padding: 1.8vw;
        border: 1px solid #ccc;
    }
    textarea {
        width: 97.5%;
        padding: 0.72vw;
        margin-top: 0.4vw;
    }
    input {
        width: 95%;
        padding: 0.72vw;
        margin-top: 0.4vw;
    }
    h2 {
        text-align: center;
    }
    .section h3 {
        border-bottom: 1px solid black;
        margin-bottom: 0.4vw;
    }
</style>
<div class="container">
    <!-- Left Side: Form -->
    <div class="form-container">
        <h2>Enter Your Details</h2>
        <form id="resumeForm" action="preview.php" method="POST">
            <label>Full Name:</label>
            <input type="text" name="name" required>

            <label>Address:</label>
            <input type="text" name="address" required>

            <label>Phone:</label>
            <input type="text" name="phone" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Birthday:</label>
            <input type="date" name="birthday" required>

            <label>Gender:</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label>Language:</label>
            <textarea name="language" rows="5" required></textarea>

            <label>Skills:</label>
            <textarea name="skill" rows="5" required></textarea>

            <label>Company Name:</label>
            <input type="text" name="companyname">

            <label>Start Date:</label>
            <input type="date" name="cstartdate">

            <label>Position:</label>
            <input type="text" name="cposition">

            <label>University:</label>
            <input type="text" name="varsityname">

            <label>CGPA:</label>
            <input type="text" name="cgpa">

            <label>Passing Year:</label>
            <input type="text" name="varsitypyear">

            <label>College:</label>
            <input type="text" name="collegename">

            <label>HSC GPA:</label>
            <input type="text" name="hscgpa">

            <label>Passing Year:</label>
            <input type="text" name="clgpyear">

            <label>School:</label>
            <input type="text" name="schoolname">

            <label>SSC GPA:</label>
            <input type="text" name="sscgpa">

            <label>Passing Year:</label>
            <input type="text" name="sclpyear">

            <button type="submit">Add Information</button>
        </form>
    </div>

    <!-- Right Side: Resume Preview -->
    <div class="preview-container">
        <h2 id="previewName">Your Name</h2>
        <p><strong>Address:</strong> <span id="previewAddress">Your address</span></p>
        <p><strong>Email:</strong> <span id="previewEmail">your.email@example.com</span></p>
        <p><strong>Phone:</strong> <span id="previewPhone">123-456-7890</span></p>
        <p><strong>Birthday:</strong> <span id="previewBirthday">Your birthday</span></p>
        <p><strong>Gender:</strong> <span id="previewGender">Your gender</span></p>
        <p><strong>Languages:</strong> <span id="previewLanguage">Your languages</span></p>

        <div class="section">
            <h3>Education</h3>
            <p><strong>University:</strong> <span id="previewVarsityname">Your university</span> 
                <span id="previewCgpa">CGPA</span> 
                <span id="previewVarsitypyear">Year</span></p>
            <p><strong>College:</strong> <span id="previewCollegename">Your college</span> 
                <span id="previewHscgpa">HSC GPA</span> 
                <span id="previewClgpyear">Year</span></p>
            <p><strong>School:</strong> <span id="previewSchoolname">Your school</span> 
                <span id="previewSscgpa">SSC GPA</span> 
                <span id="previewSclpyear">Year</span></p>
        </div>

        <div class="section">
            <h3>Experience</h3>
            <p><span id="previewCompanyname">Company Name</span> - 
                <span id="previewCposition">Position</span> 
                (<span id="previewCstartdate">Start Date</span>)</p>
        </div>

        <div class="section">
            <h3>Skills</h3>
            <p id="previewSkill">Your skills</p>
        </div>
    </div>
</div>
</main>
<script>
    document.querySelectorAll("input, textarea, select").forEach(input => {
        input.addEventListener("input", function() {
            const previewId = "preview" + input.name.charAt(0).toUpperCase() + input.name.slice(1);
            const previewElement = document.getElementById(previewId);
            if (previewElement) {
                previewElement.innerHTML = this.value ? 
                    this.value.replace(/\n/g, "<br>") : 
                    "Your " + input.name;
            }
        });
    });
</script>

</body>
</html>