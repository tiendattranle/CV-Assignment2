<style>
    .wrapper {
        max-width: 1100px;
        margin: 40px auto;
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .cv-container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar styling */
    .sidebar {
        width: 260px;
        background-color: #1e3a5f;
        color: white;
        padding: 30px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sidebar .profile-pic img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .sidebar .full-name {
        font-size: 1.4rem;
        margin-bottom: 5px;
    }

    .sidebar .job-title {
        font-size: 1rem;
        font-weight: 300;
        margin-bottom: 20px;
    }

    .contact-info {
        list-style: none;
        font-size: 0.9rem;
        margin-bottom: 25px;
        text-align: center;
    }

    .skills-section,
    .languages-section {
        margin-bottom: 20px;
    }

    .skills-section h3,
    .languages-section h3 {
        font-size: 1rem;
        margin-bottom: 5px;
        border-bottom: 1px solid #ffffff50;
    }

    /* Main content styling */
    .main-content {
        flex: 1;
        padding: 40px;
    }

    .section-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        padding: 20px 30px;
    }

    .section-card h2 {
        color: #1e3a5f;
        margin-bottom: 15px;
        font-size: 1.4rem;
    }

    .section-card .item {
        margin-bottom: 15px;
    }

    .section-card .item h3 {
        font-size: 1.1rem;
        color: #0f2745;
    }

    .section-card .item .date {
        font-size: 0.9rem;
        color: #555;
        display: block;
        margin: 3px 0 5px;
    }

    .section-card .item p {
        font-size: 0.95rem;
        color: #444;
    }
</style>
<div class="wrapper">
    <div class="cv-container">
        <aside class="sidebar">
            <div class="profile-pic">
                <img src="images/default-image.jpg" alt="Profile Picture">
            </div>
            <h2 class="full-name">John Doe</h2>
            <p class="job-title">Software Engineer</p>
            <ul class="contact-info">
                <li><strong>Address:</strong> 123 Main St, Springfield</li>
                <li><strong>Phone:</strong> +1 234 567 890</li>
                <li><strong>Email:</strong> johndoe@example.com</li>
            </ul>

            <div class="skills-section">
                <h3>Tech Stack</h3>
                <p>HTML, CSS, JavaScript, PHP, MySQL</p>
            </div>
            <div class="languages-section">
                <h3>Languages</h3>
                <p>English, Spanish</p>
            </div>
        </aside>

        <main class="main-content">
            <section class="section-card">
                <h2>Work History</h2>
                <div class="item">
                    <h3>Software Engineer - TechCorp Inc.</h3>
                    <span class="date">January 2021 - Present</span>
                    <p>Developing and maintaining web applications using modern technologies.</p>
                </div>
            </section>

            <section class="section-card">
                <h2>Education</h2>

                <div class="item">
                    <h3>University of Springfield</h3>
                    <span class="date">Graduated: 2020</span>
                    <p>CGPA: 3.9</p>
                </div>

                <div class="item">
                    <h3>Springfield College</h3>
                    <span class="date">Graduated: 2016</span>
                    <p>GPA: 4.0</p>
                </div>

                <div class="item">
                    <h3>Springfield High School</h3>
                    <span class="date">Graduated: 2014</span>
                    <p>GPA: 5.0</p>
                </div>
            </section>
        </main>
    </div>
</div>