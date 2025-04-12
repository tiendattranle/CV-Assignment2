<?php
include_once("config.php");

$query = mysqli_query($conn, "SELECT * FROM cv_info WHERE id = '" . $_GET["id"] . "'");
$data = mysqli_fetch_array($query);
mysqli_close($conn);

?>

<style>
    .body {
        margin: 0 auto;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        padding: 20px;
    }

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
<div class="body">
    <div class="wrapper">
        <div class="cv-container">
            <aside class="sidebar">
                <div class="profile-pic">
                    <img src="uploads/<?php echo $data['image'] ?: 'default-image.jpg'; ?>" alt="Profile Picture">
                </div>
                <h2 class="full-name"><?php echo $data['name']; ?></h2>
                <p class="job-title"><?php echo $data['cposition']; ?></p>
                <ul class="contact-info">
                    <li><strong>Address:</strong> <?php echo $data['address']; ?></li>
                    <li><strong>Phone:</strong> <?php echo $data['phone']; ?></li>
                    <li><strong>Email:</strong> <?php echo $data['email']; ?></li>
                </ul>

                <div class="skills-section">
                    <h3>Tech Stack</h3>
                    <p><?php echo $data['skill']; ?></p>
                </div>
                <div class="languages-section">
                    <h3>Languages</h3>
                    <p><?php echo $data['language']; ?></p>
                </div>
            </aside>

            <main class="main-content">
                <section class="section-card">
                    <h2>Work History</h2>
                    <div class="item">
                        <h3><?php echo $data['cposition'] . " - " . $data['companyname']; ?></h3>
                        <span class="date"><?php echo $data['cstartdate']; ?></span>
                        <p><!-- Optional Description --></p>
                    </div>
                </section>

                <section class="section-card">
                    <h2>Education</h2>

                    <div class="item">
                        <h3><?php echo $data['varsityname']; ?></h3>
                        <span class="date">Graduated: <?php echo $data['varsitypyear']; ?></span>
                        <p>CGPA: <?php echo $data['cgpa']; ?></p>
                    </div>

                    <div class="item">
                        <h3><?php echo $data['collegename']; ?></h3>
                        <span class="date">Graduated: <?php echo $data['clgpyear']; ?></span>
                        <p>GPA: <?php echo $data['hscgpa']; ?></p>
                    </div>

                    <div class="item">
                        <h3><?php echo $data['schoolname']; ?></h3>
                        <span class="date">Graduated: <?php echo $data['sclpyear']; ?></span>
                        <p>GPA: <?php echo $data['sscgpa']; ?></p>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <div class="share-link-container">
            <label for="share-link"><strong>Share this CV:</strong></label><br>
            <input id="share-link" type="text" value="<?php echo htmlspecialchars($shareLink); ?>" readonly>
            <br>
            <button onclick="copyLink()">Copy Link</button>
        </div>
    </div>

    <script>
        function copyLink() {
            const input = document.getElementById("share-link");
            input.select();
            input.setSelectionRange(0, 99999); // For mobile
            document.execCommand("copy");
            alert("Link copied to clipboard!");
        }
    </script>
</div>
