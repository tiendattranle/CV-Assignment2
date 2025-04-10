<?php
include_once("config.php");

if(isset($_POST["submit"]) && $_POST["password"] == $_POST["retpassword"]){
	$username = trim($_POST["username"]);
	$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
	$query = "INSERT INTO login (username, email, password) VALUES ('$username', '$_POST[email]', '$password')";

	// value insert in cv_info table
	$queryinfo = "INSERT INTO cv_info (email, birthday, gender, username) VALUES ('$_POST[email]', '$_POST[dob]', '$_POST[gender]', '$username')";

	if(mysqli_query($conn, $query)){
		mysqli_query($conn, $queryinfo);
		mysqli_close($conn);
		header("Location: ../?page=log-in");
	}
	else{
		die('Error: ' . mysqli_error($conn));
	}
}
else{
	header("Location: ../?page=sign-up");
}

mysqli_close($conn);
?>