<?php
session_start();
include_once("login_db.php");

// Redirect to index if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Clear error message after displaying it
$errorMessage = '';
if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="login_db.php" method="post">
        <div class="login-box">
            <img src="Image/avatar.png" id="avatar" alt="Avatar">
            <h1>Sign In</h1>
            <img src="Image/user.png" id="icon" alt="User Icon">
            <input type="text" name="username" placeholder="Username" required>
            <img src="Image/lock.png" id="icon2" alt="Lock Icon">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <?php
            // Display validation error if it exists
            if (!empty($errorMessage)) {
                echo "<span style='color:red; padding:20px;'>$errorMessage</span>";
            }
            ?>
            <input type="submit" name="login" value="Login">
            <a href="#">Forgot Password?</a>
        </div>
        <section id="line"></section>
        <div class="reg-link">
            <label>Don't have an account?</label>
            <a href="register.php">REGISTER HERE</a>
        </div>
    </form>
</body>
</html>