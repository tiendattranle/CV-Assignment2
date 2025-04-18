<style>
    #header {
        background-color: #2c3e50;
        padding: 15px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    #navbar {
        list-style: none;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    #navbar .lists {
        position: relative;
        margin: 0 20px;
    }

    .options {
        color: white;
        text-decoration: none;
        font-weight: bold;
        padding: 10px 15px;
        display: block;
        transition: background 0.3s;
    }

    .options:hover {
        background-color: #34495e;
        border-radius: 5px;
    }

    #sub_bar {
        display: none;
        position: absolute;
        background-color: #34495e;
        top: 100%;
        left: 0;
        min-width: 150px;
        z-index: 999;
        border-radius: 0 0 6px 6px;
        overflow: hidden;
    }

    .lists:hover #sub_bar {
        display: block;
    }

    .sub_lists a {
        color: white;
        padding: 10px;
        text-decoration: none;
        display: block;
        transition: background 0.2s ease-in-out;
    }

    .sub_lists a:hover {
        background-color: #1abc9c;
    }

    #container {
        display: flex;
        margin: 100px auto;
        max-width: 1000px;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    #left-div {
        width: 35%;
        background-color: #ecf0f1;
        padding: 20px;
        text-align: center;
    }

    .left-top-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
    }

    #left-middle-div, #left-bottom-div, #left-bottom-languages-div {
        margin-top: 20px;
        text-align: left;
    }

    #left-middle-div h2, #left-bottom-div h2, #left-bottom-languages-div h2 {
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
    }

    .left-logo, #email-logo, #skills-logo, #language-logo {
        width: 16px;
        height: 16px;
        vertical-align: middle;
        margin-right: 8px;
    }

    #right-div {
        width: 65%;
        padding: 30px;
    }

    #right-div h1 {
        font-size: 24px;
        color: #2c3e50;
        margin-bottom: 15px;
        border-bottom: 2px solid #1abc9c;
        padding-bottom: 5px;
    }

    #name-institute {
        font-size: 20px;
        font-weight: bold;
        color: #34495e;
    }

    .description {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 8px;
    }

    .right-logo {
        width: 24px;
        height: 24px;
        vertical-align: middle;
        margin-right: 10px;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: #2c3e50;
        color: white;
        font-size: 14px;
        margin-top: 40px;
    }

    @media screen and (max-width: 768px) {
        #container {
            flex-direction: column;
        }

        #left-div, #right-div {
            width: 100%;
            padding: 20px;
        }

        #navbar {
            flex-direction: column;
        }

        .lists {
            margin: 10px 0;
        }
    }
</style>

<div id="container">
    <div id="left-div">
        <img src="uploads/default-image.jpg" class="left-top-image" alt="Profile Image"><br>

        <div id="left-middle-div">
            <h2 id="name">John Doe</h2>
            <p><img src="images/home-logo.png" class="left-logo">123 Main Street, Cityville</p>
            <p><img src="images/phone-logo.png" class="left-logo">+1 234 567 8900</p>
            <p><img src="images/email-logo.png" id="email-logo">johndoe@example.com</p>
        </div><br>

        <div id="left-bottom-div">
            <h2 id="skills"><img src="images/skills-logo.png" id="skills-logo"> Skills</h2>
            <p id="skills-dtl">HTML, CSS, JavaScript, PHP, MySQL, Git</p>
        </div>

        <div id="left-bottom-languages-div">
            <h2 id="skills"><img src="images/language-logo.png" id="language-logo"> Languages</h2>
            <p id="skills-dtl">English, Spanish, French</p>
        </div>
    </div>

    <div id="right-div">
        <div id="right-top-div">
            <h1><img src="images/working-logo.png" class="right-logo"> Work Experience</h1>
            <h2 id="name-institute">TechCorp Inc.</h2>
            <h5 class="description">Software Engineer</h5>
            <p class="description">Jan 2020 – Present</p>
        </div><br>

        <div id="right-bottom-div">
            <h1><img src="images/cap-logo.png" class="right-logo"> Education</h1>

            <div id="varsity-div">
                <h2 id="name-institute">State University</h2>
                <h4 class="description">CGPA: 3.8</h4>
                <h5 class="description">Graduated: 2019</h5>
            </div><br>

            <div id="college-div">
                <h2 id="name-institute">City College</h2>
                <h4 class="description">GPA: 4.0</h4>
                <h5 class="description">Graduated: 2015</h5>
            </div><br>

            <div id="school-div">
                <h2 id="name-institute">Greenwood High School</h2>
                <h4 class="description">GPA: 5.0</h4>
                <h5 class="description">Graduated: 2013</h5>
            </div>
        </div>
    </div>
</div>
