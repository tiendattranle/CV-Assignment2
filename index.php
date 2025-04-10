<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="Navigation_bar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo"><a href="index.php">CV</a></div>
            <ul id="navbar" class="nav-links">
                <li><a href="?page=home">Home</a></li>
                <li id="cv"><a>CV Management</a>
                    <ul class="dropdown">
                        <li><a href="?page=demo">My CV</a></li>
                        <li><a href="?page=update-cv">Update CV</a></li>
                        <li><a href="?page=create-cv">Create New CV</a></li>
                    </ul>
                </li>
                <li><a href="?page=template">Templates</a></li>
                <li><a href="?page=contact">Contact</a></li>
                <?php
                    if (!isset($_SESSION["role"])) {
                        echo '<li><a href="?page=log-in">Log in</a></li>
                            <li><a href="?page=sign-up">Sign up</a></li>';
                    }
                    else {
                        echo '<li><a href="?page=sign-out">Log out</a></li>';
                    }
                ?>
            </ul>
            <button class="menu-toggle">&#9776;</button>
        </nav>
    </header>        
    <main>
    <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                $allowed_pages = ['home', 'demo', 'create-cv', 'template', 'contact', 'log-in', 'sign-up', 'sign-out'];
                if (in_array($page, $allowed_pages)) {
                    
                        include("$page.php");
                } 
                else {
                    include("404.html"); 
                }
            ?>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-logo">CV Builder</div>
            <div class="footer-socials">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">LinkedIn</a>
            </div>
            <div class="footer-text">© 2025 CV Builder. All rights reserved.</div>
        </div>
    </footer>
</body>
</html>