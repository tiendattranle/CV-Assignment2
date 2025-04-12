<?php
session_start();
include_once("../config.php");
include_once("../login_db.php");

$query = mysqli_query($conn, "SELECT * FROM cv_info WHERE username = '$_SESSION[username]'");
$data = mysqli_fetch_array($query);
mysqli_close($conn);
?>

<?php
// Generate the shareable link
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$shareLink = $protocol . $host . $uri;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Colorful CV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0faff;
            color: #333;
            padding: 20px;
        }

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

        .share-link-container {
            margin: 20px auto;
            text-align: center;
            max-width: 1000px;
        }

        .share-link-container input {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 10px 0;
            font-size: 0.95rem;
        }

        .share-link-container button {
            padding: 10px 20px;
            background-color: #53a3ff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .share-link-container button:hover {
            background-color: #3b8aff;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Top Header Section -->
        <header class="top-section">
            <div class="profile-pic">
                <img src="uploads/<?php echo $data['image'] ?: 'default-image.jpg'; ?>" alt="Profile Picture">
            </div>
            <div class="info">
                <h1><?php echo $data['name']; ?></h1>
                <h3><?php echo $data['cposition']; ?></h3>

                <div class="contact-info">
                    <p><strong>📍</strong> <?php echo $data['address']; ?></p>
                    <p><strong>📞</strong> <?php echo $data['phone']; ?></p>
                    <p><strong>✉️</strong> <?php echo $data['email']; ?></p>
                </div>

                <div class="skills-languages">
                    <div>
                        <h4>Tech Stack</h4>
                        <p><?php echo $data['skill']; ?></p>
                    </div>
                    <div>
                        <h4>Languages</h4>
                        <p><?php echo $data['language']; ?></p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <section class="section-card">
                <h2>Work Experience</h2>
                <div class="item">
                    <h3><?php echo $data['cposition'] . " - " . $data['companyname']; ?></h3>
                    <span class="date"><?php echo $data['cstartdate']; ?></span>
                    <p><!-- Optional job description here --></p>
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
    
    <div class="share-link-container">
        <label for="share-link"><strong>Share this CV:</strong></label><br>
        <input id="share-link" type="text" value="<?php echo htmlspecialchars($shareLink); ?>" readonly>
        <br>
        <button onclick="copyLink()">Copy Link</button>
    </div>

    <script>
        function copyLink() {
            const input = document.getElementById("share-link");
            input.select();
            input.setSelectionRange(0, 99999); // For mobile compatibility
            try {
                document.execCommand("copy");
                alert("Link copied to clipboard!");
            } catch (err) {
                alert("Failed to copy the link. Please copy it manually.");
            }
        }
    </script>
</body>
</html>
