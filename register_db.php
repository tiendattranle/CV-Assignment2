<?php
include_once("config.php");

if (isset($_POST["submit"])) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $retPassword = $_POST["retpassword"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];

    if ($password !== $retPassword) {
        header("Location: ../?page=sign-up&error=password_mismatch");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements for login table
    $stmtLogin = $conn->prepare("INSERT INTO login (username, email, password) VALUES (?, ?, ?)");
    $stmtLogin->bind_param("sss", $username, $email, $hashedPassword);

    // Use prepared statements for cv_info table
    // $stmtInfo = $conn->prepare("INSERT INTO cv_info (email, birthday, gender, username) VALUES (?, ?, ?, ?)");
    // $stmtInfo->bind_param("ssss", $email, $dob, $gender, $username);

    if ($stmtLogin->execute()) {
        $stmtInfo->execute(); // execute second only if first succeeds
        $stmtLogin->close();
        $stmtInfo->close();
        $conn->close();
        header("Location: ../?page=log-in");
        exit();
    } else {
        die('Error: ' . $stmtLogin->error);
    }
} else {
    header("Location: ../?page=sign-up");
    exit();
}
?>
