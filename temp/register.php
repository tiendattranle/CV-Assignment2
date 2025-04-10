<?php
include_once("login_db.php");

if(isset($_SESSION['username'])){
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="Log_Reg.css">
    <script type="text/javascript">
        function validateForm(event) {
            // Get form values
            var password = document.getElementById("psw").value;
            var retpassword = document.getElementById("retpsw").value;
            var terms = document.querySelector('input[name="terms"]:checked');

            // Check if passwords match
            if (password !== retpassword) {
                alert("Passwords do not match. Please try again.");
                event.preventDefault(); // Prevent form submission
                return false;
            }

            // Check if terms are agreed
            if (!terms) {
                alert("You must agree to the Terms and Conditions.");
                event.preventDefault(); // Prevent form submission
                return false;
            }

            alert("Registration done! Please login.");
            return true;
        }
    </script>
</head>
<body>
    <form action="register_db.php" method="post" onsubmit="return validateForm(event)">
        <div class="registration">
            <h1>Registration</h1>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" id="psw" placeholder="Password" required>
            <input type="password" name="retpassword" id="retpsw" placeholder="Retype password" required>
            <label>Birthday</label>
            <input type="date" name="dob" required>
        </div>
        <div class="reginfo">
            <div>
                <input type="radio" name="gender" value="male" required> Male
                <input type="radio" name="gender" value="female" required> Female
            </div>
            <div>
                <label>
                    <input type="checkbox" name="terms" required> I agree with the <a href="#">Terms and Conditions</a>
                </label>
            </div>
            <div>
                <input type="submit" name="submit" value="Sign Up">
            </div>
        </div>
    </form> 
</body>
</html>