<script>
    function validateForm(event) {
        var password = document.getElementById("psw").value;
        var retpassword = document.getElementById("retpsw").value;

        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            event.preventDefault();
            return false;
        }

        if (password !== retpassword) {
            alert("Passwords do not match.");
            event.preventDefault();
            return false;
        }

        alert("Registration successful! Please login.");
        return true;
    }
</script>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (strlen($_POST["password"]) < 8) {
            die("Error: Password must be at least 8 characters long.");
        }

        if ($_POST["password"] == $_POST["retpassword"]) {
            include_once("config.php");
            $username = trim($_POST["username"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $query = "INSERT INTO login (username, email, password) VALUES ('$username', '$_POST[email]', '$password')";

            // value insert in cv_info table
            $queryinfo = "INSERT INTO cv_info (email, birthday, gender, username) VALUES ('$_POST[email]', '$_POST[dob]', '$_POST[gender]', '$username')";

            if (mysqli_query($conn, $query)) {
                mysqli_query($conn, $queryinfo);
                mysqli_close($conn);
                header("Location: ?page=log-in");
            } else {
                die('Error: ' . mysqli_error($conn));
            }
            mysqli_close($conn);
        }
    }
?>
<link rel="stylesheet" href="css/sign-up.css">
<div class="sign-up-container">
    <form action="" method="post" onsubmit="return validateForm(event)">
        <h1>Create Account</h1>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" id="psw" placeholder="Password" required>
        <input type="password" name="retpassword" id="retpsw" placeholder="Retype Password" required>

        <h2 for="dob">Birthday</h2>
        <input type="date" name="dob" id="dob" required>

        <h2>Gender</h2>
        <div class="radio-group">
            <label id="male">Male</label>
            <input type="radio" id="male" name="gender" value="male" required>
            <label id="female">Female</label>
            <input type="radio" id="female" name="gender" value="female" required>
        </div>


        <div style="text-align: center;">
            <input type="submit" name="submit" value="Sign Up" class="btn-reg">
        </div>

        <div class="log-link">
            <span>Already have an account?</span>
            <a style="text-decoration: none;" href="?page=log-in">Log in Here</a>
        </div>
    </form>
</div>