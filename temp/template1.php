<?php
session_start();
include_once("config.php");
include_once("login_db.php");

$query = mysqli_query($conn, "SELECT * FROM cv_info WHERE username = '$_SESSION[username]'");
$data = mysqli_fetch_array($query);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My CV</title>
    <link rel="stylesheet" type="text/css" href="Navigation_bar.css">
    <link rel="stylesheet" type="text/css" href="CV.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div id="container">
    <div id="left-div">
        <img src="uploads/<?php echo $data['image'] ?: 'default-image.jpg'; ?>" class="left-top-image" alt="Profile Image"><br>

        <div id="left-middle-div">
            <h2 id="name"><?php echo $data['name']; ?></h2>
            <p><img src="Image/home-logo.png" class="left-logo"><?php echo $data['address']; ?></p>
            <p><img src="Image/phone-logo.png" class="left-logo"><?php echo $data['phone']; ?></p>
            <p><img src="Image/email-logo.png" id="email-logo"><?php echo $data['email']; ?></p>
        </div><br>

        <div id="left-bottom-div">
            <h2 id="skills"><img src="Image/skills-logo.png" id="skills-logo"> Skills</h2>
            <p id="skills-dtl"><?php echo $data['skill']; ?></p>
        </div>

        <div id="left-bottom-languages-div">
            <h2 id="skills"><img src="Image/language-logo.png" id="language-logo"> Languages</h2>
            <p id="skills-dtl"><?php echo $data['language']; ?></p>
        </div>
    </div>

    <div id="right-div">
        <div id="right-top-div">
            <h1><img src="Image/working-logo.png" class="right-logo"> Work Experience</h1>
            <h2 id="name-institute"><?php echo $data['companyname']; ?></h2>
            <h5 class="description"><?php echo $data['cposition']; ?></h5>
            <p class="description"><?php echo $data['cstartdate']; ?></p>
        </div><br>

        <div id="right-bottom-div">
            <h1><img src="Image/cap-logo.png" class="right-logo"> Education</h1>

            <div id="varsity-div">
                <h2 id="name-institute"><?php echo $data['varsityname']; ?></h2>
                <h4 class="description">CGPA: <?php echo $data['cgpa']; ?></h4>
                <h5 class="description">Graduated: <?php echo $data['varsitypyear']; ?></h5>
            </div><br>

            <div id="college-div">
                <h2 id="name-institute"><?php echo $data['collegename']; ?></h2>
                <h4 class="description">GPA: <?php echo $data['hscgpa']; ?></h4>
                <h5 class="description">Graduated: <?php echo $data['clgpyear']; ?></h5>
            </div><br>

            <div id="school-div">
                <h2 id="name-institute"><?php echo $data['schoolname']; ?></h2>
                <h4 class="description">GPA: <?php echo $data['sscgpa']; ?></h4>
                <h5 class="description">Graduated: <?php echo $data['sclpyear']; ?></h5>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> - RM</p>
</footer>
</body>
</html>
