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
    <title>Professional CV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CV.css">
</head>
<body>
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

                <!-- Optional footer -->
                <!-- <footer class="footer">
                    <p>&copy; <?php echo date('Y'); ?> - JD Portfolio</p>
                </footer> -->
            </main>
        </div>
    </div>
</body>
</html>
