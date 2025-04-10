<script>
    function validateForm(event) {
        var password = document.getElementById("psw").value;
        var retpassword = document.getElementById("retpsw").value;

        if (password !== retpassword) {
            alert("Passwords do not match.");
            event.preventDefault();
            return false;
        }
        alert("Registration successful! Please login.");
        return true;
    }
</script>
<link rel="stylesheet" href="css/sign-up.css">
<div class="sign-up-container">
    <form action="register_db.php" method="post" onsubmit="return validateForm(event)">
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