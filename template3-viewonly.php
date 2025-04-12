<style>
    .wrapper {
        max-width: 1000px;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Header Info */
    .top-section {
        background: linear-gradient(135deg, #58b4ae, #a4d4ae);
        padding: 30px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 30px;
        border-bottom: 5px solid #53a3ff;
    }

    .top-section .profile-pic img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 4px solid #fff;
        object-fit: cover;
    }

    .top-section .info {
        flex: 1;
        color: #fff;
        text-align: left;
    }

    .top-section .info h1 {
        font-size: 2.2rem;
        margin-bottom: 5px;
    }

    .top-section .info h3 {
        font-weight: 400;
        font-size: 1.3rem;
        margin-bottom: 15px;
    }

    .contact-info p {
        margin-top: 10px;
        font-size: 0.95rem;
        color: #fff;
        line-height: 1.4;
        text-align: left;
    }

    .skills-languages {
        display: flex;
        gap: 30px;
        margin-top: 15px;
    }

    .skills-languages h4 {
        font-size: 1rem;
        margin-bottom: 5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.5);
    }

    .skills-languages p {
        font-size: 0.9rem;
    }

    /* Main Section */
    .main-content {
        padding: 30px;
    }

    .section-card {
        background-color: #e7f1ff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0, 80, 180, 0.1);
    }

    .section-card h2 {
        font-size: 1.6rem;
        margin-bottom: 20px;
        color: #275778;
        border-left: 6px solid #53a3ff;
        padding-left: 12px;
    }

    .item {
        margin-bottom: 20px;
    }

    .item h3 {
        font-size: 1.2rem;
        color: #333;
    }

    .date {
        font-size: 0.9rem;
        color: #666;
        margin: 5px 0;
        display: block;
    }

    .item p {
        font-size: 0.95rem;
        color: #444;
    }
</style>
<div class="wrapper">
    <!-- Top Header Section -->
    <header class="top-section">
        <div class="profile-pic">
            <img src="images/default-image.jpg" alt="Profile Picture">
        </div>
        <div class="info">
            <h1>Jane Doe</h1>
            <h3>UI/UX Designer</h3>

            <div class="contact-info">
                <p><strong>📍</strong> 456 Elm Street, Design City</p>
                <p><strong>📞</strong> +123 456 7890</p>
                <p><strong>✉️</strong> jane.doe@example.com</p>
            </div>

            <div class="skills-languages">
                <div>
                    <h4>Tech Stack</h4>
                    <p>Figma, Adobe XD, HTML, CSS, JavaScript</p>
                </div>
                <div>
                    <h4>Languages</h4>
                    <p>English, French</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <section class="section-card">
            <h2>Work Experience</h2>
            <div class="item">
                <h3>UI/UX Designer - Creative Agency</h3>
                <span class="date">March 2022 - Present</span>
                <p>Designed user-centered interfaces for web and mobile platforms.</p>
            </div>
        </section>

        <section class="section-card">
            <h2>Education</h2>

            <div class="item">
                <h3>Design University</h3>
                <span class="date">Graduated: 2021</span>
                <p>CGPA: 3.8</p>
            </div>

            <div class="item">
                <h3>Modern College</h3>
                <span class="date">Graduated: 2017</span>
                <p>GPA: 4.9</p>
            </div>

            <div class="item">
                <h3>Artistic High School</h3>
                <span class="date">Graduated: 2015</span>
                <p>GPA: 5.0</p>
            </div>
        </section>
    </main>
</div>