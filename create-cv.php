<style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            display: flex;
            gap: 20px;
        }
        .container {
            display: flex;
            width: 100%;
        }
        .form-container, .preview-container {
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
        }
        textarea, input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        h2 {
            text-align: center;
        }
        .section h3 {
            border-bottom: 1px solid black;
            margin-bottom: 10px;
        }
    </style>
<div class="container">
    <!-- Left Side: Form -->
    <div class="form-container">
        <h2>Enter Your Details</h2>
        <form id="resumeForm" action="preview.php" method="POST">
            <label>Full Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Address:</label><br>
            <input type="text" name="address" required><br><br>

            <label>Phone:</label><br>
            <input type="text" name="phone" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Birthday:</label><br>
            <input type="date" name="birthday" required><br><br>

            <label>Gender:</label><br>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br><br>

            <label>Language:</label><br>
            <textarea name="language" required></textarea><br><br>

            <label>Skills:</label><br>
            <textarea name="skill" required></textarea><br><br>

            <label>Company Name:</label><br>
            <input type="text" name="companyname"><br><br>

            <label>Start Date:</label><br>
            <input type="date" name="cstartdate"><br><br>

            <label>Position:</label><br>
            <input type="text" name="cposition"><br><br>

            <label>University:</label><br>
            <input type="text" name="varsityname"><br><br>

            <label>CGPA:</label><br>
            <input type="text" name="cgpa"><br><br>

            <label>Passing Year:</label><br>
            <input type="text" name="varsitypyear"><br><br>

            <label>College:</label><br>
            <input type="text" name="collegename"><br><br>

            <label>HSC GPA:</label><br>
            <input type="text" name="hscgpa"><br><br>

            <label>Passing Year:</label><br>
            <input type="text" name="clgpyear"><br><br>

            <label>School:</label><br>
            <input type="text" name="schoolname"><br><br>

            <label>SSC GPA:</label><br>
            <input type="text" name="sscgpa"><br><br>

            <label>Passing Year:</label><br>
            <input type="text" name="sclpyear"><br><br>

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