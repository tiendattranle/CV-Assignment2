<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("config.php");

if (isset($_POST["login"])) { // Make sure this matches the `name="login"` in your form
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        unset($_SESSION['errorMessage']);
        header("Location: index.php?page=home");
        exit();
    } else {
        $_SESSION['errorMessage'] = "Invalid username or password.";
        header("Location: index.php?page=log-in");
        exit();
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("Location: index.php?page=log-in");
    exit();
}
?>
