<?php
session_start();
include_once("config.php");
include_once("login_db.php");

$query = mysqli_query($conn, "SELECT * FROM cv_info WHERE username = '$_SESSION[username]'");
$data = mysqli_fetch_array($query);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Colorful CV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CV.css">
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
</body>
</html>
