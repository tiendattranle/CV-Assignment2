<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header("Location: ?page=home");
    exit();
}

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("config.php");

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Use prepared statement
    $stmt = $conn->prepare("SELECT password FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username;
            $stmt->close();
            $conn->close();
            header("Location: ?page=home");
            exit();
        }
    }

    // If login fails
    $_SESSION['errorMessage'] = "Invalid username or password. Please try again.";
    header("Location: ?page=log-in");
    exit();
}

// Display and clear error
if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
}
?>

<link rel="stylesheet" href="css/log-in.css">
<div class="log-in-container">
    <form action="" method="post" class="login-form">
        <div class="login-box">
            <img style="width: 30%; margin-bottom: auto; " src="https://cdn-icons-png.flaticon.com/512/1999/1999625.png" alt="Avatar">
            <h1>Welcome Back Babyboo</h1>

            <?php if (!empty($errorMessage)): ?>
                <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
            <?php endif; ?>

            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
                <i class="fas fa-user icon"></i>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock icon"></i>
            </div>

            <input type="submit" name="login" value="Login" class="btn-login">

            <div class="reg-link">
                <span>Don't have an account?</span>
                <a style="text-decoration: none;" href="?page=sign-up">Sign Up Here</a>
            </div>
        </div>
    </form>
</div>